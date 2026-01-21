<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobPostedByClient extends Notification
{
    use Queueable;

    public mixed $jobPost;

    /**
     * Create a new notification instance.
     */
    public function __construct($job)
    {
        $this->jobPost = $job;
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
            ->subject('🎉 Your Job Post Was Successfully Created!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your job post titled:')
            ->line('#JB-' . $this->jobPost->id . ' ' . ucwords($this->jobPost->title))
            ->line('has been successfully posted on our platform.')
            ->line('we will verify job posts shortly. Once verified, it will become visible to eligible professionals.')
            ->line('Thank you for choosing our platform to find top talent!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $title = ucwords($this->jobPost->title);
        $jobId = $this->jobPost->id;

        $this->sendWhatsAppMessage($notifiable, $jobId, $title);

        return [
            'type' => 'client_job_created',
            'message' => '<b>#JB-' . $this->jobPost->id . ' ' . ucwords($this->jobPost->title) . '</b> has been successfully posted. We will verify job posts shortly.',
            'title' => 'Job Post Created',
            'link' => route('users.jobs.show', ['job' => $this->jobPost]),
            'data' => ['job_post_id' => $this->jobPost->id]
        ];
    }

    protected function sendWhatsAppMessage($notifiable, $jobId, $title)
    {
        if (!$notifiable->primary_mobile_number) {
            return;
        }

        $params = [
            'jobId' => $jobId,
            'title' => $title,
        ];

        try {
            $whatsapp = new WhatsAppService();
            $whatsapp->sendMessage($notifiable->primary_mobile_number, 'job_posted_by_client', $params);
        } catch (\Exception $e) {
            \Log::error("WhatsApp sending failed for JobPostedByClient: " . $e->getMessage());
        }
    }

}
