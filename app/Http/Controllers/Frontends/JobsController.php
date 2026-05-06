<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.jobs.index');
    }

    public function show(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            abort(404, 'Job ID is required');
        }

        $job = JobPost::with([
            'categories',
            'bids.vendor',
            'assignedVendor',
            'postedBy.serviceproviderprofile'
        ])->findOrFail($id);

        $is_registered = false;
        if (auth()->check()) {
            $is_registered = Payment::where('job_id', $job->id)
                ->where('user_id', auth()->id())
                ->where('payment_for', 'job_registration')
                ->where('status', PaymentStatus::COMPLETED)
                ->exists();
        }

        return view('frontend.jobs.show', compact('job', 'is_registered'));
    }

    public function registrationPayment($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $job = JobPost::findOrFail($id);
        $deposit = $job->cost * 0.01;

        $alreadyRegistered = Payment::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->where('payment_for', 'job_registration')
            ->where('status', PaymentStatus::COMPLETED)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()
                ->route('frontend.jobs.index')
                ->with('success', 'You are already registered for this job.');
        }

        Payment::create([
            'user_id'     => auth()->id(),
            'job_id'      => $job->id,
            'amount'      => $deposit,
            'payment_id'  => 'TEST_' . uniqid(),
            'payment_for' => 'job_registration',
            'status'      => PaymentStatus::COMPLETED,
            'method'      => 'test'
        ]);

        return redirect()
            ->route('frontend.jobs.index')
            ->with('success', 'Test Registration Successful! Now you can bid.');
    }

    // ✅ FIXED fetchJobs with tab filter
    public function fetchJobs(Request $request)
    {
        $filters = $request->filters;
        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }

        $query = JobPost::with(['categories', 'postedBy.serviceproviderprofile']);

        // ✅ Tab filter
        $tab = $request->tab ?? 'all';

        switch ($tab) {
            case 'live':
                $query->where('auction_status', 'live');
                break;

            case 'upcoming':
                $query->whereIn('status', ['pending', 'verified', 'under verification'])
                      ->where(function($q) {
                          $q->whereNull('auction_start')
                            ->orWhere('auction_start', '>', now());
                      });
                break;

            case 'closed':
                $query->where(function($q) {
                    $q->whereIn('status', ['closed', 'assigned', 'completed'])
                      ->orWhere('auction_status', 'closed');
                });
                break;

            default: // all
                $query->where(function($q) {
                    $q->whereNotIn('status', ['pending'])
                      ->orWhere('auction_status', 'live');
                });
                break;
        }

        // Search filters
        if (!empty($filters)) {
            $query->where(function ($q) use ($filters) {
                if (!empty($filters['search_by_location'])) {
                    $q->where('location', 'LIKE', '%' . $filters['search_by_location'] . '%')
                      ->orWhere('pin_code', $filters['search_by_location']);
                }
                if (!empty($filters['search'])) {
                    $q->where('title', 'LIKE', '%' . $filters['search'] . '%');
                }
                if (!empty($filters['categories'])) {
                    $q->whereHas('categories', function ($catQuery) use ($filters) {
                        $catQuery->whereIn('category_id', $filters['categories']);
                    });
                }
            });
        }

        $jobs = $query->orderBy('id', 'desc')
            ->skip($request->skip ?? 0)
            ->limit(8)
            ->get()
            ->map(function ($job) {
                $job->is_registered = auth()->check()
                    ? Payment::where('job_id', $job->id)
                        ->where('user_id', auth()->id())
                        ->where('payment_for', 'job_registration')
                        ->where('status', PaymentStatus::COMPLETED)
                        ->exists()
                    : false;
                $job->cost = (float) $job->cost;
                return $job;
            });

        return response()->json([
            'jobs'       => $jobs,
            'categories' => Category::select(['id', 'name'])->get(),
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        try {
            DB::beginTransaction();

            Payment::create([
                'user_id'     => auth()->id(),
                'job_id'      => $request->job_id,
                'amount'      => $request->amount,
                'payment_id'  => $request->razorpay_payment_id,
                'payment_for' => 'job_registration',
                'status'      => PaymentStatus::COMPLETED,
                'method'      => 'razorpay'
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Registration successful!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function assignWinner(Request $request)
    {
        $request->validate([
            'job_id'    => 'required|exists:job_posts,id',
            'winner_id' => 'required|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            $job = JobPost::findOrFail($request->job_id);
            $job->update([
                'winner_id' => $request->winner_id,
                'status'    => 'closed'
            ]);

            $refundedCount = Payment::where('job_id', $job->id)
                ->where('user_id', '!=', $request->winner_id)
                ->where('payment_for', 'job_registration')
                ->where('status', PaymentStatus::COMPLETED)
                ->update([
                    'status'      => PaymentStatus::REFUNDED,
                    'refunded_at' => now()
                ]);

            DB::commit();

            return back()->with('success', "Winner assigned and $refundedCount users marked for refund.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}