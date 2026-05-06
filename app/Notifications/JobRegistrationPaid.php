<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobRegistrationPaid extends Notification
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        // Load relationships to avoid "property of non-object" error in mail
        $this->payment = $payment->load('job');
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Bidding URL logic
        // Hum user ko direct us job ke show page par bhej rahe hain jahan bidding modal open ho sake
        $biddingUrl = route('frontend.jobs.show', [
            'job' => $this->payment->job_id, 
            'open_bid' => 'true'
        ]);

        return (new MailMessage)
            ->subject('Registration Confirmed & Bidding Link: ' . ($this->payment->job->title ?? 'Job Post'))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Badhai ho! Aapka registration payment successfully verify ho gaya hai.')
            ->line('Ab aap is job ke liye bidding start kar sakte hain.')
            
            ->line('**--- Invoice Details ---**')
            ->line('Job Name: ' . ($this->payment->job->title ?? 'N/A'))
            ->line('Transaction ID: ' . $this->payment->transaction_id)
            // Yahan check karein: agar column name 'amount' hai toh wahi likhein
            ->line('Amount Paid: ₹' . number_format($this->payment->amount, 2)) 
            
            ->action('Start Bidding Now', $biddingUrl)
            
            ->line('**Refund Policy:** Agar aap bidding nahi jeet-te hain, toh aapka registration amount automatically refund process kar diya jayega.')
            ->line('Best of luck for the auction!')
            ->salutation('Regards, ' . config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'job_id' => $this->payment->job_id,
            'amount' => $this->payment->amount,
        ];
    }
}