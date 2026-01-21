<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorProfileVerifiedEmail extends Notification
{
    use Queueable;

    public $user;

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
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
            ->subject('Congratulations! Your CtrlF Profile is Now Verified')
            ->view('emails.vendor-profile-verified-email', [
                'user' => $this->user,
                'notifiable' => $notifiable
            ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'vendor-registration-confirmation-email',
            'message' => 'Your Registration is Received - ' . $this->user->name,
            'title' => 'Welcome to CtrlF - Your Registration is Received!',
            'link' => '',
            'data' => ['user_id' => $this->user->id],
        ];
    }

}
