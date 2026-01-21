<?php

namespace App\Notifications;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientJobPostingUpdateToVendor extends Notification implements ShouldQueue
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
//    public function toMail(object $notifiable)
//    {
//        return (new MailMessage)
//            ->subject('Opportunity Knocks! New Job Posted in Your Service Categories')
//            ->view('emails.client-job-posting-update-to-vendor', [
//                'job' => $this->job,
//                'notifiable' => $notifiable
//            ]);
//    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $this->sendWhatsAppMessage($notifiable);

        return [
            'type' => 'client-job-posting-update-to-vendor',
            'message' => 'Opportunity Knocks! New Job Posted in Your Service Categories',
            'title' => 'Opportunity Knocks! New Job Posted in Your Service Categories',
            'link' => '',
            'data' => ['job_id' => $this->job->id],
        ];
    }

    protected function sendWhatsAppMessage($notifiable)
    {
        if (!$notifiable->primary_mobile_number) {
            return;
        }

        $params = [
            'name' => $notifiable->name ?? 'NA',
            'title' => $this->job->title ?? 'NA',
            'it' => $this->job->id ?? 'NA',
            'posted_on' => $this->job->created_at
                ? \Carbon\Carbon::parse($this->job->created_at)->format('d-m-Y h:i A')
                : 'NA',
            'location' => $this->job->location ?? 'NA',
            'category' => $this->job->categories && $this->job->categories->count() > 0
                ? implode(', ', $this->job->categories->pluck('name')->toArray())
                : 'NA',
        ];


        try {
            $whatsapp = new WhatsAppService();
            $whatsapp->sendMessage($notifiable->primary_mobile_number, 'client_job_posting_updat_to_vendor', $params);
        } catch (\Exception $e) {
            \Log::error("WhatsApp sending failed for JobStatus: " . $e->getMessage());
        }
    }

}
