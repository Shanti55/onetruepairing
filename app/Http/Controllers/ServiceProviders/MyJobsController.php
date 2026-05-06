<?php

namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobBid;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyJobsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $userId = auth()->id();

                $data = JobBid::with(['jobPost' => function($q) {
                    $q->withTrashed()->with('categories');
                }])
                ->where('vendor_id', $userId)
                ->latest()
                ->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('job_id', function ($row) {
                        if (!$row->jobPost) return '—';
                        return 'EL#' . str_pad($row->jobPost->id, 5, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('title', function ($row) {
                        $job = $row->jobPost;
                        if (!$job) return '<span class="text-danger">Job Not Found</span>';

                        $jobTitle    = e($job->title ?? 'N/A');
                        $jobDesc     = $job->description ?? '';
                        $jobLocation = e($job->area ?? $job->location ?? 'N/A');
                        $jobPrice    = number_format($job->cost ?? 0, 2);
                        $jobDuration = ($job->duration_value ?? '0') . ' / ' . ucfirst($job->duration_type ?? 'Hours');
                        $uniqueId    = $row->id;
                        $showUrl     = route('service-providers.my-jobs.show', ['job' => $row->job_post_id]);

                        $html  = '<div class="d-flex flex-column">';
                        $html .= '<a href="' . $showUrl . '" class="fw-bold text-dark text-decoration-none mb-1">' . $jobTitle . '</a>';

                        if ($jobDesc) {
                            $html .= '<span class="text-muted small mb-1">' . \Str::limit($jobDesc, 50) . '</span>';
                        }

                        $html .= '<div class="d-flex flex-wrap gap-1 mb-1">';
                        if ($job->categories && $job->categories->count()) {
                            foreach ($job->categories as $cat) {
                                $html .= '<span class="badge bg-light text-dark" style="font-size:10px;">' . e($cat->name) . '</span>';
                            }
                        }
                        $html .= '</div>';

                        $html .= '<div class="d-flex flex-wrap gap-3 small text-muted">';
                        $html .= '<span><i class="bi bi-geo-alt-fill me-1"></i>' . $jobLocation . '</span>';
                        $html .= '<span><i class="bi bi-currency-rupee me-1"></i>' . $jobPrice . '</span>';
                        $html .= '<span><i class="bi bi-clock me-1"></i>' . e($jobDuration) . '</span>';

                        if ($jobDesc) {
                            $html .= '<a href="javascript:void(0)" class="text-warning small"
                                         data-bs-toggle="collapse"
                                         data-bs-target="#desc_' . $uniqueId . '">
                                         <i class="bi bi-info-circle me-1"></i>More Details
                                      </a>';
                        }
                        $html .= '</div>';

                        if ($jobDesc) {
                            $html .= '<div class="collapse mt-2" id="desc_' . $uniqueId . '">
                                        <div class="p-3 rounded bg-light border small text-muted">
                                            ' . nl2br(e($jobDesc)) . '
                                        </div>
                                      </div>';
                        }

                        $html .= '</div>';
                        return $html;
                    })
                    ->addColumn('bid_amount', function ($row) {
                        if (!$row->amount) return '—';
                        $lowestBid = JobBid::where('job_post_id', $row->job_post_id)->min('amount');
                        $badge = ($row->amount == $lowestBid)
                            ? ' <span class="badge bg-success ms-1" style="font-size:10px;">Lowest</span>'
                            : '';
                        return '₹' . number_format($row->amount, 2) . $badge;
                    })
                    ->addColumn('status', function ($row) {
                        $job = $row->jobPost;
                        if (!$job) return '—';

                        // ✅ Enum issue fix — getRawOriginal use karo
                        $status   = $job->getRawOriginal('status') ?? 'pending';
                        $isWinner = $job->assigned_to == auth()->id();

                        return match(true) {
                            $status === 'assigned' && $isWinner  => '<span class="badge bg-success">🏆 You Won</span>',
                            $status === 'assigned' && !$isWinner => '<span class="badge bg-secondary">Not Selected</span>',
                            $status === 'completed'              => '<span class="badge bg-primary">Completed</span>',
                            $status === 'open'                   => '<span class="badge bg-success">Live</span>',
                            $status === 'closed'                 => '<span class="badge bg-secondary">Closed</span>',
                            default => '<span class="badge bg-warning text-dark">' . ucfirst($status) . '</span>',
                        };
                    })
                    ->addColumn('progress_bar', function ($row) {
                        $job      = $row->jobPost;
                        $progress = 0;
                        if ($job) {
                            // ✅ Enum issue fix
                            $status   = $job->getRawOriginal('status') ?? '';
                            $progress = match($status) {
                                'open'      => 25,
                                'closed'    => 50,
                                'assigned'  => 75,
                                'completed' => 100,
                                default     => 10,
                            };
                        }
                        $color = $progress === 100 ? 'bg-success' : ($progress >= 50 ? 'bg-primary' : 'bg-warning');
                        return '<div class="progress mb-1" style="height:6px;border-radius:4px;">
                                    <div class="progress-bar ' . $color . '" style="width:' . $progress . '%"></div>
                                </div>
                                <small class="text-muted">' . $progress . '%</small>';
                    })
                    ->addColumn('action', function ($row) {
                        if (!$row->jobPost) return '—';
                        $url = route('service-providers.my-jobs.show', ['job' => $row->job_post_id]);
                        return '<a href="' . $url . '" class="btn btn-sm btn-light border">
                                    <i class="bi bi-eye text-success"></i>
                                </a>';
                    })
                    ->rawColumns(['job_id', 'title', 'bid_amount', 'status', 'progress_bar', 'action'])
                    ->make(true);

            } catch (\Exception $e) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                ], 500);
            }
        }

        return view('service-provider-panel.job-posts.my-jobs.index');
    }

    public function show(Request $request, JobPost $job)
    {
        $serviceprovider = auth()->user();
        $profile = $serviceprovider->serviceproviderprofile
            ? $serviceprovider->serviceproviderprofile()->first()
            : null;

        return view('service-provider-panel.my-jobs.show', [
            'job'             => $job,
            'serviceprovider' => $serviceprovider,
            'profile'         => $profile,
        ]);
    }
}