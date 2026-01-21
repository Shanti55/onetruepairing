<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientJobApplicationAcceptance extends Notification
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
            ->subject('New Task Assigned')
            ->view('emails.task_assigned', [
                'task' => $this->task,
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
            'type' => 'work_task_assigned',
            'message' => 'Task Assigned - ' . $this->task->title,
            'title' => 'New Task Assigned',
            'link' => route('tasks.index'),
            'data' => ['task_id' => $this->task->id],
        ];
    }
}
