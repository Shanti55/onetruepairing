<?php

use App\Http\Controllers\Admins\AdminsController;
use App\Http\Controllers\Admins\BlogController;
use App\Http\Controllers\Admins\CategoriesController;
use App\Http\Controllers\Admins\JobPosts\JobPostsAssignedToUpdateController;
use App\Http\Controllers\Admins\JobPosts\JobPostsController;
use App\Http\Controllers\Admins\JobPosts\JobPostsStatusUpdateController;
use App\Http\Controllers\Admins\JobPosts\JobBiddingController;
use App\Http\Controllers\Admins\RolesPermissionController;
use App\Http\Controllers\Admins\ServiceProvidersController;
use App\Http\Controllers\Admins\ServicesController;
use App\Http\Controllers\Admins\SubscriptionPlansController;
use App\Http\Controllers\Admins\UsersController;
use App\Http\Controllers\Admins\UsersOfflineVerificationUpdateController;
use App\Http\Controllers\Admins\UsersStatusUpdateController;
use App\Http\Controllers\ServiceProviders\ProfileSettingsController;
use App\Http\Controllers\ServiceProviders\JobBidController;
use App\Http\Controllers\JobRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

// ─────────────────────────────────────────────
// PUBLIC UTILITY ROUTES
// ─────────────────────────────────────────────

Route::get('/get-pincode/{pincode}', function ($pincode) {
    $response = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])
        ->timeout(10)->retry(3, 200)
        ->get("https://api.postalpincode.in/pincode/" . $pincode);
    return response()->json($response->json());
});

Route::get('/auth/redirect-login', fn() => redirect()->route('frontend.auth.login'))->name('login');

// ─────────────────────────────────────────────
// FRONTEND PAGES
// ─────────────────────────────────────────────

Route::get('/', fn() => view('frontend.index'))->name('frontend.home');
Route::get('/about-us', fn() => view('frontend.about-us.index'))->name('frontend.about-us');
Route::get('/benefits-of-listings', fn() => view('frontend.benefits-of-listings.index'))->name('frontend.benefits-of-listings');
Route::get('/contact', fn() => view('frontend.contact'))->name('frontend.contact');
Route::get('/terms-and-conditions', fn() => view('frontend.terms-and-conditions.index'))->name('frontend.terms-and-conditions');
Route::get('/privacy-policy', fn() => view('frontend.privacy-policy.index'))->name('frontend.privacy-policy');
Route::get('/customer-agreement', fn() => view('frontend.customer-agreements.index'))->name('frontend.customer-agreements');
Route::get('/refund-policy', fn() => view('frontend.refund-policies.index'))->name('frontend.refund-policies');
Route::get('/faqs', fn() => view('frontend.faqs.index'))->name('frontend.faqs');
Route::get('/pricing', fn() => view('frontend.pricing.index'))->name('frontend.pricing.index');
Route::get('/home', fn() => view('home'))->name('home')->middleware('auth:web');

// ─────────────────────────────────────────────
// FRONTEND BLOGS
// ─────────────────────────────────────────────

Route::get('blogs', [\App\Http\Controllers\Frontends\BlogController::class, 'index'])->name('frontend.blogs');
Route::get('blogs/get-data', [\App\Http\Controllers\Frontends\BlogController::class, 'getData'])->name('frontend.blogs.get-data');
Route::get('/blogs/{blog}', fn(\App\Models\Blog $blog) => view('frontend.blogs.show', compact('blog')))->name('frontend.blogs.show');

// ─────────────────────────────────────────────
// AUTH
// ─────────────────────────────────────────────

Route::get('/login', fn() => view('frontend.auth.login'))->name('frontend.auth.login')->middleware('custom-guest');
Route::get('/register', fn() => view('frontend.auth.register'))->name('frontend.auth.register');
Route::get('/email/verify-notice', fn() => view('frontend.auth.verify-email-notice'))->name('verification.notice');

Route::get('service-provider/register', fn() => view('frontend.auth.service-providers.register'))->name('frontend.auth.service-providers.register');
Route::post('service-provider/register', [RegisteredUserController::class, 'store'])->name('service-providers.register');

Route::get('service-provider/login', fn() => view('frontend.auth.service-providers.login'))->name('frontend.auth.service-providers.login')->middleware('custom-guest');
Route::post('service-provider/login', [AuthenticatedSessionController::class, 'store'])->name('service-providers.auth.login');
Route::post('admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.auth.login');

Route::get('/otp-login', [\App\Http\Controllers\OtpController::class, 'showLoginForm'])->name('otp-login');
Route::post('/send-otp', [\App\Http\Controllers\OtpController::class, 'sendOtp'])->name('send-otp');
Route::post('/login-otp', [\App\Http\Controllers\OtpController::class, 'loginWithOtp'])->name('login-otp');

// ─────────────────────────────────────────────
// FRONTEND PUBLIC DATA ROUTES
// ─────────────────────────────────────────────

Route::get('categories/data', \App\Http\Controllers\Frontends\CategoryListController::class)->name('categories.data');

Route::get('jobs/', [\App\Http\Controllers\Frontends\JobsController::class, 'index'])->name('frontend.jobs.index');
Route::get('jobs/get-data', [\App\Http\Controllers\Frontends\JobsController::class, 'fetchJobs'])->name('frontend.jobs.get-data');
Route::get('jobs/show', [\App\Http\Controllers\Frontends\JobsController::class, 'show'])->name('frontend.jobs.show');

Route::get('browse/listings', [\App\Http\Controllers\Frontends\BrowseListingsController::class, 'index'])->name('frontend.browse-listings.index');
Route::get('browse/listings/get-data', [\App\Http\Controllers\Frontends\BrowseListingsController::class, 'fetchListings'])->name('frontend.browse-listings.get-data');
Route::get('advertisements/get-ads', [\App\Http\Controllers\Frontends\BrowseListingsController::class, 'fetchListingsAds'])->name('frontend.browse-listings.get-ads');

Route::get('service-provider/show/{provider}', [\App\Http\Controllers\Frontends\ServiceProvidersController::class, 'show'])->name('frontend.service-providers.show');

Route::get('notification/get-job-status', [\App\Http\Controllers\InboxController::class, 'getJobStatus'])->name('notification.get-job-status');
Route::get('notification/get-offline-verification-status', [\App\Http\Controllers\InboxController::class, 'getOfflineVerificationStatus'])->name('notification.get-offline-verification-status');

Route::post('/modal-close', function (\Illuminate\Http\Request $request) {
    session([$request->modal => true]);
    return response()->json(['status' => 'ok']);
})->name('frontend.modal.close');

Route::post('enquiry/create', [\App\Http\Controllers\EnquiryController::class, 'store'])->name('frontend.enquiries.store');

// ─────────────────────────────────────────────
// AUTHENTICATED ROUTES
// ─────────────────────────────────────────────

Route::middleware(['auth:web'])->group(function () {

    // ── Notifications ─────────────────────────────────────────────────────────
    Route::get('/notifications/read/{id}', function ($id) {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['action_url']);
        }
        return back();
    })->name('notifications.read');

    Route::get('inbox/get-notifications', [\App\Http\Controllers\InboxController::class, 'getNotifications'])->name('inbox.get-notifications');
    Route::get('inbox/get-unread-count', [\App\Http\Controllers\InboxController::class, 'getUnReadCount'])->name('inbox.get-unread-count');
    Route::get('inbox/read-notification', [\App\Http\Controllers\InboxController::class, 'readNotification'])->name('inbox.read-notification');

    // ── Common Routes ─────────────────────────────────────────────────────────
    Route::post('rate-review/storeOrUpdate', [\App\Http\Controllers\RateAndReviewController::class, 'storeOrUpdate'])->name('rate-review.storeOrUpdate');
    Route::delete('media/delete', \App\Http\Controllers\DeleteMediaController::class)->name('media.delete');
    Route::delete('avatar/delete', \App\Http\Controllers\DeleteAvatarController::class)->name('avatar.delete');
    Route::delete('cover-image/delete', \App\Http\Controllers\DeleteCoverImageController::class)->name('cover-image.delete');
    Route::post('switch/{user}/user-profile', \App\Http\Controllers\SwitchFromUserToServiceProviderController::class)->name('switch.user-profile');
    Route::delete('account/{user}/delete', \App\Http\Controllers\DeleteAccountController::class)->name('account.delete');
    Route::post('service-providers/profile/update', \App\Http\Controllers\ServiceProviders\ProfileUpdateController::class)->name('service-providers.profile.update');
    Route::post('job-posts/storeOrUpdate', [\App\Http\Controllers\Frontends\JobPostsController::class, 'storeOrUpdate'])->name('frontend.job-posts.storeOrUpdate');
    Route::post('job-posts/update-status', \App\Http\Controllers\Admins\JobPosts\JobPostsStatusUpdateController::class)->name('job-posts.updateStatus');
    Route::post('subscriptions/purchase', \App\Http\Controllers\PurchaseSubscriptionController::class)->name('subscriptions.purchase');
    Route::post('payment/requests', \App\Http\Controllers\PaymentRequestsController::class)->name('payment.requests');
    Route::post('payment/updateStatus', \App\Http\Controllers\PaymentStatusUpdateController::class)->name('payment.updateStatus');
    Route::get('jobs/registration-payment/{id}', [\App\Http\Controllers\Frontends\JobsController::class, 'registrationPayment'])->name('jobs.payment');
    Route::post('jobs/payment-success', [\App\Http\Controllers\Frontends\JobsController::class, 'paymentSuccess'])->name('jobs.payment.success');
    Route::post('jobs/acceptance', \App\Http\Controllers\ServiceProviders\JobPostsAcceptanceController::class)->name('job-posts.acceptance');
    Route::post('admin/payments/{payment}/verify', [JobRegistrationController::class, 'verifyPaymentByAdmin'])->name('admin.payments.verify');

    // ── Job Registration ───────────────────────────────────────────────────────
    Route::get('/job-registration/{job}', [JobRegistrationController::class, 'showRegistrationForm'])->name('job.registration.show');
    Route::post('/job-registration/{job}/submit', [JobRegistrationController::class, 'storeManualPayment'])->name('job.registration.submit');

    // ─── USER ROUTES ──────────────────────────────────────────────────────────
    Route::middleware('user')->group(function () {
        Route::get('job-posts/createOrUpdate', [\App\Http\Controllers\Frontends\JobPostsController::class, 'createOrUpdate'])->name('frontend.job-posts.createOrUpdate');
        Route::prefix('account')->group(function () {
            Route::get('profile', [\App\Http\Controllers\Frontends\MyAccounts\ManageProfileController::class, 'index'])->name('users.profile.index');
            Route::post('profile/storeOrUpdate', [\App\Http\Controllers\Frontends\MyAccounts\ManageProfileController::class, 'storeOrUpdate'])->name('users.profile.storeOrUpdate');
            Route::get('jobs', [\App\Http\Controllers\Frontends\MyAccounts\MyJobsController::class, 'index'])->name('users.jobs.index');
            Route::get('jobs/show/{job}', [\App\Http\Controllers\Frontends\MyAccounts\MyJobsController::class, 'show'])->name('users.jobs.show');
            Route::get('notifications', [\App\Http\Controllers\Frontends\MyAccounts\MyNotificationsController::class, 'index'])->name('users.notifications.index');
        });
    });

    // ─── ADMIN ROUTES ─────────────────────────────────────────────────────────
    Route::middleware('admin')->prefix('admin')->group(function () {

        Route::get('dashboard', fn() => view('admin-panel.dashboard'))->name('admins.dashboard');

        // ── Auction Room ──────────────────────────────────────────────────────
        Route::get('auction-room', [JobPostsController::class, 'auctionRoom'])->name('admin.auction.room');

        // ── Manage Bids ───────────────────────────────────────────────────────
        Route::get('manage-bids', [JobBiddingController::class, 'index'])->name('admin.manage-bids.index');
        Route::get('manage-bids/{id}', [JobBiddingController::class, 'show'])->name('admin.manage-bids.show');
        Route::post('manage-bids/hire', [JobBiddingController::class, 'hire'])->name('admin.manage-bids.hire');

        // ── Admins ────────────────────────────────────────────────────────────
        Route::get('admins', [AdminsController::class, 'index'])->name('admins.index');
        Route::post('admins', [AdminsController::class, 'storeOrUpdate'])->name('admins.storeOrUpdate');
        Route::get('admins/{admin}', [AdminsController::class, 'edit'])->name('admins.edit');
        Route::delete('admins/{admin}', [AdminsController::class, 'destroy'])->name('admins.delete');

        // ── Users ─────────────────────────────────────────────────────────────
        Route::get('users/export', [UsersController::class, 'export'])->name('users.export');
        Route::delete('users/bulk-delete', [UsersController::class, 'bulkDelete'])->name('users.bulk-delete');
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::post('users', [UsersController::class, 'storeOrUpdate'])->name('users.storeOrUpdate');
        Route::get('users/{user}', [UsersController::class, 'edit'])->name('users.edit');
        Route::get('users/show/{user}', [UsersController::class, 'show'])->name('users.show');
        Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.delete');
        Route::post('users/updateStatus', UsersStatusUpdateController::class)->name('users.updateStatus');
        Route::post('users/offlineVerification', UsersOfflineVerificationUpdateController::class)->name('users.offlineVerification');

        // ── Service Providers ─────────────────────────────────────────────────
        Route::get('serviceproviders/export', [ServiceProvidersController::class, 'export'])->name('serviceproviders.export');
        Route::post('serviceproviders/import', [ServiceProvidersController::class, 'import'])->name('serviceproviders.import');
        Route::delete('serviceproviders/bulk-delete', [UsersController::class, 'bulkDelete'])->name('serviceproviders.bulk-delete');
        Route::get('serviceproviders', [ServiceProvidersController::class, 'index'])->name('serviceproviders.index');
        Route::post('serviceproviders', [ServiceProvidersController::class, 'storeOrUpdate'])->name('serviceproviders.storeOrUpdate');
        Route::get('serviceproviders/{serviceprovider}', [ServiceProvidersController::class, 'edit'])->name('serviceproviders.edit');
        Route::get('serviceproviders/show/{serviceprovider}', [ServiceProvidersController::class, 'show'])->name('serviceproviders.show');
        Route::get('serviceproviders/update/{serviceprovider}', [ServiceProvidersController::class, 'update'])->name('serviceproviders.update');
        Route::get('serviceproviders/billing/{serviceprovider}', [ServiceProvidersController::class, 'billing'])->name('serviceproviders.billing');
        Route::delete('serviceproviders/{serviceprovider}', [ServiceProvidersController::class, 'destroy'])->name('serviceproviders.delete');

        // ── Enquiry ───────────────────────────────────────────────────────────
        Route::get('enquiry', [\App\Http\Controllers\EnquiryController::class, 'index'])->name('enquiry.index');

        // ── Categories ────────────────────────────────────────────────────────
        Route::get('categories', [CategoriesController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoriesController::class, 'storeOrUpdate'])->name('categories.storeOrUpdate');
        Route::get('categories/{category}', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::delete('categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.delete');

        // ── Services ──────────────────────────────────────────────────────────
        Route::get('services', [ServicesController::class, 'index'])->name('services.index');
        Route::post('services', [ServicesController::class, 'storeOrUpdate'])->name('services.storeOrUpdate');
        Route::get('services/{service}', [ServicesController::class, 'edit'])->name('services.edit');
        Route::delete('services/{service}', [ServicesController::class, 'destroy'])->name('services.delete');

        // ── Subscription Plans ────────────────────────────────────────────────
        Route::get('subscription-plans', [SubscriptionPlansController::class, 'index'])->name('subscription-plans.index');
        Route::post('subscription-plans', [SubscriptionPlansController::class, 'storeOrUpdate'])->name('subscription-plans.storeOrUpdate');
        Route::get('subscription-plans/{plan}', [SubscriptionPlansController::class, 'edit'])->name('subscription-plans.edit');
        Route::delete('subscription-plans/{plan}', [SubscriptionPlansController::class, 'destroy'])->name('subscription-plans.delete');

        // ── Roles & Permissions ───────────────────────────────────────────────
        Route::get('roles-permissions', [RolesPermissionController::class, 'index'])->name('roles-permissions.index');
        Route::post('roles-permissions', [RolesPermissionController::class, 'storeOrUpdate'])->name('roles-permissions.storeOrUpdate');
        Route::get('roles-permissions/{roles}', [RolesPermissionController::class, 'edit'])->name('roles-permissions.edit');
        Route::delete('roles-permissions/{roles}', [RolesPermissionController::class, 'destroy'])->name('roles-permissions.delete');

        // ── Job Posts — specific routes PEHLE, {job} wale BAAD MEIN ──────────
        Route::get('job-posts/trash', [JobPostsController::class, 'trash'])->name('job-posts.trash');
        Route::post('job-posts/bulk-delete', [JobPostsController::class, 'bulkDelete'])->name('job-posts.bulkDelete');
        Route::post('job-posts/assign-winner', [JobPostsController::class, 'assignWinner'])->name('job-posts.assignWinner');
        Route::post('job-posts/make-auction-live', [JobPostsController::class, 'makeAuctionLive'])->name('job-posts.makeAuctionLive');
        Route::post('job-posts/updateAssignedTo', JobPostsAssignedToUpdateController::class)->name('job-posts.updateAssignedTo');
        Route::post('job-posts/registrations/{id}/approve', [JobPostsController::class, 'approveRegistration'])->name('registrations.approve');
        Route::post('job-posts/registrations/{id}/reject', [JobPostsController::class, 'rejectRegistration'])->name('registrations.reject');
        Route::post('job-posts/{id}/restore', [JobPostsController::class, 'restore'])->name('job-posts.restore');
        Route::delete('job-posts/{id}/force-delete', [JobPostsController::class, 'forceDelete'])->name('job-posts.forceDelete');
        Route::get('job-posts', [JobPostsController::class, 'index'])->name('job-posts.index');
        Route::post('job-posts', [JobPostsController::class, 'storeOrUpdate'])->name('job-posts.storeOrUpdate');
        Route::get('job-posts/show/{job}/{serviceprovider}', [JobPostsController::class, 'show'])->name('job-posts.show');
        Route::get('job-posts/{job}', [JobPostsController::class, 'edit'])->name('job-posts.edit');
        Route::delete('job-posts/{job}', [JobPostsController::class, 'destroy'])->name('job-posts.delete');

        // ── Billing ───────────────────────────────────────────────────────────
        Route::get('billing/subscriptions', [\App\Http\Controllers\Admins\BillingSubscriptionsController::class, 'index'])->name('billing.subscriptions.index');
        Route::get('billing/show/{serviceprovider}', [\App\Http\Controllers\Admins\BillingSubscriptionsController::class, 'show'])->name('billing.subscriptions.show');
        Route::get('billing/payments', [\App\Http\Controllers\Admins\PaymentsController::class, 'index'])->name('billing.payments.index');
        Route::get('billing/payment-requests', [\App\Http\Controllers\Admins\PaymentsController::class, 'paymentRequest'])->name('billing.payment-requests.index');

        // ── Reports ───────────────────────────────────────────────────────────
        Route::prefix('reports')->group(function () {
            Route::get('job-accepted-declined/export', [\App\Http\Controllers\Admins\Reports\JobAcceptedDeclinedController::class, 'export'])->name('job-accepted-declined.export');
            Route::get('job-accepted-declined', [\App\Http\Controllers\Admins\Reports\JobAcceptedDeclinedController::class, 'index'])->name('job-accepted-declined.index');
        });

       
// ── Admin Notifications — SAHI ORDER ─────────────────────────────────
Route::get('notifications/trash', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'trash'])->name('admins.notifications.trash');
Route::post('notifications/mark-all-read', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'markAllRead'])->name('admins.notifications.markAllRead');
Route::post('notifications/restore-all', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'restoreAll'])->name('admins.notifications.restoreAll'); // ✅ {id} se PEHLE
Route::delete('notifications/delete-all-read', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'deleteAllRead'])->name('admins.notifications.deleteAllRead');
Route::post('notifications/{id}/read', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'markAsRead'])->name('admins.notifications.read');
Route::post('notifications/{id}/restore', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'restore'])->name('admins.notifications.restore');
Route::delete('notifications/{id}/delete', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'delete'])->name('admins.notifications.delete');
Route::delete('notifications/{id}/force-delete', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'forceDelete'])->name('admins.notifications.forceDelete');
Route::get('notifications', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'index'])->name('admins.notifications.index');       

// ── Blogs ─────────────────────────────────────────────────────────────
        Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::get('blogs/edit/{blog}', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::post('blogs/store', [BlogController::class, 'store'])->name('blogs.store');
        Route::put('blogs/{blog}/update', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.delete');
        Route::post('blogs/{blog}/status', [BlogController::class, 'status'])->name('blogs.status');
        Route::delete('blogs/media/delete', [BlogController::class, 'destroyMedia'])->name('blogs.media.delete');

        // ── Settings ──────────────────────────────────────────────────────────
        Route::prefix('settings')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admins\Settings\SettingsController::class, 'index'])->name('settings.index');
            Route::post('store', [\App\Http\Controllers\Admins\Settings\SettingsController::class, 'storeOrUpdate'])->name('settings.storeOrUpdate');
            Route::get('states', [\App\Http\Controllers\Admins\StatesController::class, 'index'])->name('states.index');
            Route::post('states', [\App\Http\Controllers\Admins\StatesController::class, 'storeOrUpdate'])->name('states.storeOrUpdate');
            Route::get('states/{state}', [\App\Http\Controllers\Admins\StatesController::class, 'edit'])->name('states.edit');
            Route::delete('states/{state}', [\App\Http\Controllers\Admins\StatesController::class, 'destroy'])->name('states.delete');
            Route::get('manage-ads', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'index'])->name('manage-ads.index');
            Route::post('manage-ads', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'storeOrUpdate'])->name('manage-ads.storeOrUpdate');
            Route::get('manage-ads/{advertisement}', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'edit'])->name('manage-ads.edit');
            Route::delete('manage-ads/{advertisement}', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'destroy'])->name('manage-ads.delete');
            Route::get('business-values', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'index'])->name('business-values.index');
            Route::post('business-values', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'storeOrUpdate'])->name('business-values.storeOrUpdate');
            Route::get('business-values/{value}', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'edit'])->name('business-values.edit');
            Route::delete('business-values/{value}', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'destroy'])->name('business-values.delete');
        });
    });

    // ─── SERVICE PROVIDER ROUTES ──────────────────────────────────────────────
    Route::middleware('service-provider')->prefix('service-provider')->group(function () {

        Route::get('dashboard', fn() => view('service-provider-panel.dashboard'))->name('service-providers.dashboard');
// Service provider group mein
Route::get('bid-status/{id}', [JobBidController::class, 'show'])->name('service-provider.bid-show');
        Route::get('get-bid-status/{job_id}', [JobBidController::class, 'getBidStatus'])->name('service-provider.bid-status');
        Route::get('bid-status', [JobBidController::class, 'index'])->name('vendor.bids');
        Route::post('job/bid', [JobBidController::class, 'store'])->name('service-provider.job.bid');

        Route::get('notifications', [\App\Http\Controllers\ServiceProviders\MyNotificationsController::class, 'index'])->name('service-providers.notifications.index');
        Route::get('notifications/read/{id}', [\App\Http\Controllers\ServiceProviders\MyNotificationsController::class, 'markAsRead'])->name('notifications.read');
        Route::get('notifications/mark-all-read', [\App\Http\Controllers\ServiceProviders\MyNotificationsController::class, 'markAllRead'])->name('notifications.markAllRead');

        Route::get('profile-settings', [ProfileSettingsController::class, 'index'])->name('profile-settings.index');
        Route::get('business-listings/createOrUpdate', [\App\Http\Controllers\Frontends\BusinessListingsController::class, 'createOrUpdate'])->name('frontend.business-listings.createOrUpdate');

        Route::get('jobs/requests', [\App\Http\Controllers\ServiceProviders\JobPostRequestsController::class, 'index'])->name('service-providers.request-job-posts.index');

        Route::get('jobs/my-jobs', [\App\Http\Controllers\ServiceProviders\MyJobsController::class, 'index'])->name('service-providers.my-jobs.index');
        Route::get('jobs/my-jobs/show/{job}', [\App\Http\Controllers\ServiceProviders\MyJobsController::class, 'show'])->name('service-providers.my-jobs.show');

        Route::get('job-progress', [\App\Http\Controllers\JobProgressController::class, 'index'])->name('job-progress.index');
        Route::post('job-progress', [\App\Http\Controllers\JobProgressController::class, 'storeOrUpdate'])->name('job-progress.storeOrUpdate');
        Route::get('job-progress/{jobProgress}', [\App\Http\Controllers\JobProgressController::class, 'edit'])->name('job-progress.edit');
        Route::delete('job-progress/{jobProgress}', [\App\Http\Controllers\JobProgressController::class, 'destroy'])->name('job-progress.delete');

        Route::get('my-job-posts', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'index'])->name('service-providers.my-job-posts.index');
        Route::post('my-job-posts', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'storeOrUpdate'])->name('service-providers.my-job-posts.storeOrUpdate');
        Route::get('my-job-posts/{job}', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'edit'])->name('service-providers.my-job-posts.edit');
        Route::delete('my-job-posts/{job}', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'destroy'])->name('service-providers.my-job-posts.delete');

        Route::get('subscriptions', [\App\Http\Controllers\ServiceProviders\ProviderSubscriptionsController::class, 'index'])->name('provider.subscriptions.index');
    });
});