<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientJobPostingConfirmation extends Notification
{
    use Queueable;

    public $job;

    /**
     * Create a new notification instance.
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
            ->subject('Your Project '. $this->job->title .' is Live on CtrlF')
            ->view('emails.client-job-posting-confirmation', [
                'job' => $this->job,
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
        $status = ucwords(str_replace('_', ' ', $this->job->status->value));
        $jobTitle = ucwords($this->job->title);
        $jobId = $this->job->id;

        $this->sendWhatsAppMessage($notifiable, $jobId, $jobTitle, $status);

        return [
            'type' => 'client-job-posting-confirmation',
            'message' => 'Your Project '. $this->job->title .' is Live on CtrlF',
            'title' => 'Your Project '. $this->job->title .' is Live on CtrlF',
            'link' => '',
            'data' => ['job_id' => $this->job->id],
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
