<?php

namespace App\Jobs;

use App\Models\JobPost;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendJobNotificationsToVendors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $jobId)
    {
        $this->jobId = $jobId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $job = JobPost::with('categories')->find($this->jobId);
        if (!$job) {
            Log::error("JobPost not found: {$this->jobId}");
            return;
        }

        $categories = $job->categories()->get();

        $whatsapp = new WhatsAppService();

        User::whereHas('serviceproviderprofile', function ($query) use ($categories) {
            $query->where(function ($q) use ($categories) {
                foreach ($categories as $categoryId) {
                    $q->orWhereJsonContains('categories', (string)$categoryId->id);
                }
            });
        })->with('serviceproviderprofile')
            ->chunk(10, function ($serviceProviders) use ($whatsapp, $job) {
                foreach ($serviceProviders as $provider) {
                    if (preg_match('/@(test\.com|example\.com|fake\.com)$/i', $provider->email)) {
                        continue;
                    }
                    if (empty($provider->primary_mobile_number)) {
                        continue;
                    }

                    $params = [
                        'name' => $provider->name ?? 'NA',
                        'title' => $job->title ?? 'NA',
                        'it' => $job->id ?? 'NA',
                        'posted_on' => $job->created_at
                            ? $job->created_at->format('d-m-Y h:i A')
                            : 'NA',
                        'location' => $job->location ?? 'NA',
                        'category' => $job->categories->count() > 0
                            ? implode(', ', $job->categories->pluck('name')->toArray())
                            : 'NA',
                    ];

                    try {
                        $whatsapp->sendMessage($provider->primary_mobile_number, 'client_job_posting_updat_to_vendor', $params);
                    } catch (\Exception $e) {
                        Log::error("WhatsApp sending failed to {$provider->primary_mobile_number}: " . $e->getMessage());
                    }
                }
            });
    }
}
