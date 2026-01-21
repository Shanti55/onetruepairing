<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobStatus extends Notification
{
    use Queueable;

    public mixed $jobPost;

    /**
     * Create a new notification instance.
     */
    public function __construct($jobPost)
    {
        $this->jobPost = $jobPost;
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

        $status = ucwords(str_replace('_', ' ', $this->jobPost->status->value));
        $jobTitle = ucwords($this->jobPost->title);
        $jobId = $this->jobPost->id;

        $this->sendWhatsAppMessage($notifiable, $jobId, $jobTitle, $status);

        return [
            'type' => 'job_status',
            'message' => '<b>#JB-'.$this->jobPost->id.' '. ucwords($this->jobPost->title) . '</b> Status has been updated',
            'title' => 'New Job Status Update',
            'link' => route('users.jobs.show',['job'=>$this->jobPost]),
            'data' => ['job_post_id' => $this->jobPost->id,'current_status'=>ucwords(str_replace('_',' ',$this->jobPost->status->value)),'current_status_color'=>$this->jobPost->status->color()]
        ];
    }

    protected function sendWhatsAppMessage($notifiable, $jobId, $title, $status)
    {
        if (!$notifiable->primary_mobile_number) {
            return;
        }

        $params = [
            'title' => $title,
            'status' => $status,
        ];

        try {
            $whatsapp = new WhatsAppService();
            $whatsapp->sendMessage($notifiable->primary_mobile_number, 'job_status', $params);
        } catch (\Exception $e) {
            \Log::error("WhatsApp sending failed for JobStatus: " . $e->getMessage());
        }
    }

}
