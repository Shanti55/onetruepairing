<?php

namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobBid; 
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyJobsController extends Controller
{
    /**
     * My Jobs Table Index - 100% Dynamic with Description Toggle
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Data fetch with categories for tags
            $data = JobBid::with(['job.categories'])
                ->where('vendor_id', auth()->id())
                ->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('job_id', function ($row) {
                    return '<span class="text-gray-600 fw-bold">JB-' . ($row->job->id ?? '0') . '</span>';
                })
                ->addColumn('title', function ($row) {
                    $job = $row->job;
                    if (!$job) return '<span class="text-danger">Job Data Missing</span>';

                    // Dynamic Data from Tinker
                    $jobTitle = $job->title ?? 'N/A';
                    $jobDesc = $job->description ?? 'No description provided.';
                    $jobLocation = $job->area ?? $job->location ?? 'N/A'; 
                    $jobPrice = number_format($job->cost ?? 0, 2);
                    $jobDuration = ($job->duration_value ?? '0') . ' / ' . ucfirst($job->duration_type ?? 'Hours');
                    
                    // Unique ID for Collapse (JobBid ID use kar rahe hain)
                    $uniqueId = $row->id;
                    $showUrl = route('service-providers.my-jobs.show', ['job' => $row->job_post_id]);

                    $html = '<div class="d-flex flex-column">';
                    
                    // 1. Title (Full Page Link)
                    $html .= '<a href="' . $showUrl . '" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-6">' . $jobTitle . '</a>';
                    
                    // 2. Short Description Line (Optional, before collapse)
                    $html .= '<span class="text-muted fw-bold fs-7 mb-1">' . \Str::limit($jobDesc, 40) . '</span>';
                    
                    // 3. Category Tags
                    $html .= '<div class="d-flex flex-wrap align-items-center mb-1">';
                    if($job->categories) {
                        foreach($job->categories as $cat) {
                            $html .= '<span class="badge badge-light-dark fw-bolder my-1 me-2 px-2 py-1" style="font-size: 10px; background-color: #f5f8fa; color: #5e6278;">' . $cat->name . '</span>';
                        }
                    }
                    $html .= '</div>';

                    // 4. Icons Row
                    $html .= '<div class="d-flex align-items-center flex-wrap fs-8">';
                    $html .= '<span class="text-muted fw-bold me-4 d-flex align-items-center"><i class="bi bi-geo-alt-fill me-1" style="color: #b5b5c3;"></i>' . $jobLocation . '</span>';
                    $html .= '<span class="text-muted fw-bold me-4 d-flex align-items-center"><i class="bi bi-currency-rupee me-1" style="color: #b5b5c3;"></i>' . $jobPrice . '</span>';
                    $html .= '<span class="text-muted fw-bold me-4 d-flex align-items-center"><i class="bi bi-clock-fill me-1" style="color: #b5b5c3;"></i>' . $jobDuration . '</span>';
                    
                    // More Details Button (Bootstrap Collapse Trigger)
                    $html .= '<a href="javascript:void(0)" class="badge badge-light-warning fw-bolder px-2 py-1 text-decoration-none" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#desc_collapse_' . $uniqueId . '" 
                                aria-expanded="false" 
                                style="color: #f6c000; font-size: 9px;">
                                <i class="bi bi-info-circle me-1"></i>More Details
                              </a>';
                    $html .= '</div>';

                    // 5. Hidden Description Box (Screenshot 655 Style)
                    $html .= '<div class="collapse mt-3" id="desc_collapse_' . $uniqueId . '">
                                <div class="rounded p-4" style="background-color: #f5f8fa; border: 1px solid #eff2f5; color: #5e6278; font-size: 13px; line-height: 1.5;">
                                    ' . nl2br(e($jobDesc)) . '
                                </div>
                              </div>';

                    $html .= '</div>';
                    
                    return $html;
                })
                ->addColumn('status', function ($row) {
                    $statusText = ucfirst($row->status ?? 'Verified');
                    $color = ($row->status == 'accepted' || $row->status == 'verified' || $row->status == 'completed') ? 'success' : 'warning';
                    return '<span class="badge badge-light-' . $color . ' fw-bolder px-4 py-3">' . $statusText . '</span>';
                })
                ->addColumn('progress_bar', function ($row) {
                    return '<div class="d-flex align-items-center w-100 mw-125px">
                                <div class="progress h-6px w-100 bg-light-success" style="border-radius: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%; border-radius: 4px;"></div>
                                </div>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    // Eye Icon leads to the full show page
                    $url = route('service-providers.my-jobs.show', ['job' => $row->job_post_id]);
                    return '<a href="' . $url . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                <span class="svg-icon svg-icon-3">
                                    <i class="bi bi-eye text-success fs-2"></i>
                                </span>
                            </a>';
                })
                ->rawColumns(['job_id', 'title', 'status', 'progress_bar', 'action'])
                ->make(true);
        }

        return view('service-provider-panel.job-posts.my-jobs.index');
    }

    /**
     * Show Job Details (Full View)
     */
    public function show(Request $request, JobPost $job)
    {
        $serviceprovider = auth()->user(); 
        $profile = $serviceprovider->serviceproviderprofile ? $serviceprovider->serviceproviderprofile->first() : null;
        
        return view('service-provider-panel.job-posts.my-jobs.show', [
            'job' => $job, 
            'serviceprovider' => $serviceprovider, 
            'profile' => $profile
        ]);
    }
}