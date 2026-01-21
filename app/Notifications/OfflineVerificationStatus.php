<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfflineVerificationStatus extends Notification
{
    use Queueable;

    public mixed $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = ucwords(str_replace('_', ' ', $this->user->offline_verification->value));
        $userName = $this->user->name;
        $userId = $this->user->id;

        $this->sendWhatsAppMessage($notifiable, $userId, $userName, $status);

        return [
            'type' => 'offline_verification_status',
            'message' => '<b>Offline Verification</b> Status has been updated',
            'title' => 'Offline Verification Status Update',
            'link' => '',
            'data' => ['service_provider_id' => $this->user->id,'current_status'=>ucwords(str_replace('_',' ',$this->user->offline_verification->value)),'current_status_color'=>$this->user->offline_verification->color()]
        ];
    }

    protected function sendWhatsAppMessage($notifiable, $userId, $userName, $status)
    {
        if (!$notifiable->primary_mobile_number) {
            return;
        }

        $params = [
            'name' => $userName,
            'status' => $status,
        ];

        try {
            $whatsapp = new WhatsAppService();
            $whatsapp->sendMessage($notifiable->primary_mobile_number, 'offline_verification_status', $params);
        } catch (\Exception $e) {
            \Log::error("WhatsApp sending failed for OfflineVerificationStatus: " . $e->getMessage());
        }
    }

}
