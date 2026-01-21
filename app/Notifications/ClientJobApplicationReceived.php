<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientJobApplicationReceived extends Notification
{
    use Queueable;

    public $job;

    public $services;

    /**
     * Create a new notification instance.
     */
    public function __construct($job,$services)
    {
        $this->job = $job;
        $this->services = $services;
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
            ->subject('New Application Received for'. $this->job->title)
            ->view('emails.client-job-application-received', [
                'job' => $this->job,
                'services' => $this->services,
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
            'type' => 'client-job-application-received',
            'message' => 'New Application Received',
            'title' => 'New Application Received',
            'link' => '',
            'data' => ['job_id' => $this->job->id],
        ];
    }

}
