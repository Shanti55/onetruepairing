<?php

use App\Http\Controllers\Admins\AdminsController;
use App\Http\Controllers\Admins\BlogController;
use App\Http\Controllers\Admins\CategoriesController;
use App\Http\Controllers\Admins\JobPosts\JobPostsAssignedToUpdateController;
use App\Http\Controllers\Admins\JobPosts\JobPostsStatusUpdateController;
use App\Http\Controllers\Admins\RolesPermissionController;
use App\Http\Controllers\Admins\ServiceProvidersController;
use App\Http\Controllers\Admins\ServicesController;
use App\Http\Controllers\Admins\SubscriptionPlansController;
use App\Http\Controllers\Admins\UsersController;
use App\Http\Controllers\Admins\UsersOfflineVerificationUpdateController;
use App\Http\Controllers\Admins\UsersStatusUpdateController;
use App\Http\Controllers\ServiceProviders\ProfileSettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\JobPosts\JobBiddingController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ServiceProviders\JobBidController;
use App\Models\BusinessValue;
use Illuminate\Support\Facades\Http;

//Route::get('/preview-error/{code}', function ($code) {
//    return response()->view("errors.$code");
//});
//
//Route::get('/email', function(){
//    return view('emails.vendor-registration-confirmation-email');
//});

Route::get('/get-pincode/{pincode}', function ($pincode) {
    $response = Http::withHeaders([
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
    ])
        ->timeout(10)
        ->retry(3, 200)
        ->get("https://api.postalpincode.in/pincode/".$pincode);

    return response()->json($response->json());
});

Route::get('/auth/redirect-login', function () {
    return redirect()->route('frontend.auth.login');
})->name('login');

//Frontend
Route::get('/', function(){
    return view('frontend.index');
})->name('frontend.home');

Route::get('/about-us', function(){
    return view('frontend.about-us.index');
})->name('frontend.about-us');

Route::get('/benefits-of-listings', function(){

//    if (BusinessValue::count() === 0) {
//        BusinessValue::create([
//            'title' => '30%',
//            'description' => 'average business growth for listed vendors',
//            'icon' => 'bi-emoji-smile',
//        ]);
//
//        BusinessValue::create([
//            'title' => '40%',
//            'description' => 'average business growth for listed vendors',
//            'icon' => 'bi-journal-richtext',
//        ]);
//
//        BusinessValue::create([
//            'title' => '50%',
//            'description' => 'faster payment processing',
//            'icon' => 'bi-headset',
//        ]);
//
//        BusinessValue::create([
//            'title' => '90%',
//            'description' => 'vendor satisfaction rate',
//            'icon' => 'bi-people',
//        ]);
//    }

    return view('frontend.benefits-of-listings.index');
})->name('frontend.benefits-of-listings');

Route::get('/contact', function(){
    return view('frontend.contact');
})->name('frontend.contact');

Route::get('/terms-and-conditions', function(){
    return view('frontend.terms-and-conditions.index');
})->name('frontend.terms-and-conditions');

Route::get('/privacy-policy', function(){
    return view('frontend.privacy-policy.index');
})->name('frontend.privacy-policy');

Route::get('/customer-agreement', function(){
    return view('frontend.customer-agreements.index');
})->name('frontend.customer-agreements');

Route::get('/refund-policy', function(){
    return view('frontend.refund-policies.index');
})->name('frontend.refund-policies');







Route::get('/faqs', function(){
    return view('frontend.faqs.index');
})->name('frontend.faqs');


Route::post(
    'service-provider/job/bid',
    [\App\Http\Controllers\ServiceProviders\JobBidController::class, 'store']
)->middleware(['auth', 'service-provider'])
 ->name('service-provider.job.bid');




Route::post('/modal-close', function (\Illuminate\Http\Request $request) {
    session([$request->modal => true]);
    return response()->json(['status' => 'ok']);
})->name('frontend.modal.close');

Route::get('blogs', [\App\Http\Controllers\Frontends\BlogController::class, 'index'])->name('frontend.blogs');
Route::get('blogs/get-data', [\App\Http\Controllers\Frontends\BlogController::class, 'getData'])->name('frontend.blogs.get-data');

Route::get('/blogs/{blog}', function(\App\Models\Blog $blog){
    return view('frontend.blogs.show',compact('blog'));
})->name('frontend.blogs.show');


Route::get('/pricing', function(){
    return view('frontend.pricing.index');
})->name('frontend.pricing.index');


Route::get('/login',function (){
   return view('frontend.auth.login');
})->name('frontend.auth.login')->middleware('custom-guest');

Route::get('/register',function (){
    return view('frontend.auth.register');
})->name('frontend.auth.register');

Route::get('/email/verify-notice', function () {
    return view('frontend.auth.verify-email-notice');
})->name('verification.notice');

Route::get('service-provider/register',function (){
    return view('frontend.auth.service-providers.register');
})->name('frontend.auth.service-providers.register');

Route::post('service-provider/register', [RegisteredUserController::class, 'store'])->name('service-providers.register');


Route::get('service-provider/login',function (){
    return view('frontend.auth.service-providers.login');
})->name('frontend.auth.service-providers.login')->middleware('custom-guest');

Route::post('service-provider/login', [AuthenticatedSessionController::class, 'store'])->name('service-providers.auth.login');


//Admin
Route::get('admin/login',function (){
    return view('admin-panel.auth.login');
})->name('admin.auth.login')->middleware('custom-guest');

Route::post('admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.auth.login');

//OTP Login
Route::get('/otp-login', [\App\Http\Controllers\OtpController::class, 'showLoginForm'])->name('otp-login');
Route::post('/send-otp', [\App\Http\Controllers\OtpController::class, 'sendOtp'])->name('send-otp');
Route::post('/login-otp', [\App\Http\Controllers\OtpController::class, 'loginWithOtp'])->name('login-otp');


//Home
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth:web');

//Admin Dashboard
Route::get('admin/dashboard', function () {
    return view('admin-panel.dashboard');
})->name('admins.dashboard')->middleware('admin');

//Service Provider-Dashboard
Route::get('service-provider/dashboard', function () {
    return view('service-provider-panel.dashboard');
})->name('service-providers.dashboard')->middleware('service-provider');


//Category
Route::get('categories/data', \App\Http\Controllers\Frontends\CategoryListController::class)->name('categories.data');

//Jobs
Route::get('jobs/', [\App\Http\Controllers\Frontends\JobsController::class, 'index'])->name('frontend.jobs.index');
Route::get('jobs/get-data', [\App\Http\Controllers\Frontends\JobsController::class, 'fetchJobs'])->name('frontend.jobs.get-data');
Route::get('jobs/show', [\App\Http\Controllers\Frontends\JobsController::class, 'show'])->name('frontend.jobs.show');


//Job Posting
Route::get('job-posts/createOrUpdate', [\App\Http\Controllers\Frontends\JobPostsController::class, 'createOrUpdate'])->name('frontend.job-posts.createOrUpdate')->middleware('user');
//JobPosts-Actions
Route::post('jobs/acceptance', \App\Http\Controllers\ServiceProviders\JobPostsAcceptanceController::class)->name('job-posts.acceptance');

//Enquiry Posting
Route::post('enquiry/create', [\App\Http\Controllers\EnquiryController::class, 'store'])->name('frontend.enquiries.store');

//Business Listing
Route::get('business-listings/createOrUpdate', [\App\Http\Controllers\Frontends\BusinessListingsController::class, 'createOrUpdate'])->name('frontend.business-listings.createOrUpdate')->middleware('service-provider');
//Browse Listing
Route::get('browse/listings', [\App\Http\Controllers\Frontends\BrowseListingsController::class, 'index'])->name('frontend.browse-listings.index');
Route::get('browse/listings/get-data', [\App\Http\Controllers\Frontends\BrowseListingsController::class, 'fetchListings'])->name('frontend.browse-listings.get-data');
Route::get('advertisements/get-ads', [\App\Http\Controllers\Frontends\BrowseListingsController::class, 'fetchListingsAds'])->name('frontend.browse-listings.get-ads');

//Show Page Service Provider
Route::get('service-provider/show/{provider}',[\App\Http\Controllers\Frontends\ServiceProvidersController::class,'show'])->name('frontend.service-providers.show');



//Notifications
Route::get('notification/get-job-status', [\App\Http\Controllers\InboxController::class, 'getJobStatus'])->name('notification.get-job-status');
Route::get('notification/get-offline-verification-status', [\App\Http\Controllers\InboxController::class, 'getOfflineVerificationStatus'])->name('notification.get-offline-verification-status');



Route::group(['middleware' => ['auth:web']], function () {
    //Actions
    Route::post('service-providers/profile/update', \App\Http\Controllers\ServiceProviders\ProfileUpdateController::class)->name('service-providers.profile.update');
    Route::post('job-posts/storeOrUpdate', [\App\Http\Controllers\Frontends\JobPostsController::class, 'storeOrUpdate'])->name('frontend.job-posts.storeOrUpdate');
    //Action-Update Job Status
    Route::post('job-posts/updateStatus', JobPostsStatusUpdateController::class)->name('job-posts.updateStatus');
    //Action-Purchase Subscription
    Route::post('subscriptions/purchase', \App\Http\Controllers\PurchaseSubscriptionController::class)->name('subscriptions.purchase');
    //Action-Purchase Subscription
    Route::post('payment/requests', \App\Http\Controllers\PaymentRequestsController::class)->name('payment.requests');
    //Action-Update Job Status
    Route::post('payment/updateStatus', \App\Http\Controllers\PaymentStatusUpdateController::class)->name('payment.updateStatus');

    //Fetch Notifications
    Route::get('inbox/get-notifications', [\App\Http\Controllers\InboxController::class, 'getNotifications'])->name('inbox.get-notifications');
    //Fetch Unread Notification Counts
    Route::get('inbox/get-unread-count', [\App\Http\Controllers\InboxController::class, 'getUnReadCount'])->name('inbox.get-unread-count');
    //Mark As Read
    Route::get('inbox/read-notification', [\App\Http\Controllers\InboxController::class, 'readNotification'])->name('inbox.read-notification');
    //Rate and Review
    Route::post('rate-review/storeOrUpdate', [\App\Http\Controllers\RateAndReviewController::class, 'storeOrUpdate'])->name('rate-review.storeOrUpdate');
    //Delete From Media
    Route::delete('media/delete', \App\Http\Controllers\DeleteMediaController::class)->name('media.delete');
    Route::delete('avatar/delete', \App\Http\Controllers\DeleteAvatarController::class)->name('avatar.delete');
    Route::delete('cover-image/delete', \App\Http\Controllers\DeleteCoverImageController::class)->name('cover-image.delete');

    //Action-Become Service Provider
    Route::post('switch/{user}/user-profile', \App\Http\Controllers\SwitchFromUserToServiceProviderController::class)->name('switch.user-profile');

    //Delete Account
    Route::delete('account/{user}/delete', \App\Http\Controllers\DeleteAccountController::class)->name('account.delete');

    //User Login
    Route::group(['middleware' => 'user'],function (){

            Route::group(['prefix' => 'account'],function (){
                //Users-Profile
                Route::get('profile', [\App\Http\Controllers\Frontends\MyAccounts\ManageProfileController::class, 'index'])->name('users.profile.index');
                Route::post('profile/storeOrUpdate', [\App\Http\Controllers\Frontends\MyAccounts\ManageProfileController::class, 'storeOrUpdate'])->name('users.profile.storeOrUpdate');

                //Users-Jobs
                Route::get('jobs', [\App\Http\Controllers\Frontends\MyAccounts\MyJobsController::class, 'index'])->name('users.jobs.index');
                Route::get('jobs/show/{job}', [\App\Http\Controllers\Frontends\MyAccounts\MyJobsController::class, 'show'])->name('users.jobs.show');

                //Notifications
                Route::get('notifications', [\App\Http\Controllers\Frontends\MyAccounts\MyNotificationsController::class, 'index'])->name('users.notifications.index');

            });

    });

    //Admin Login
    Route::group(['prefix' => 'admin','middleware' => 'admin'],function () {
            //Notifications
            Route::get('notifications', [\App\Http\Controllers\Admins\MyNotificationsController::class, 'index'])->name('admins.notifications.index');


            Route::get('manage-bids', [\App\Http\Controllers\Admins\JobPosts\JobBiddingController::class, 'index'])->name('admin.manage-bids.index');
    Route::get('manage-bids/{id}', [\App\Http\Controllers\Admins\JobPosts\JobBiddingController::class, 'show'])->name('admin.manage-bids.show');
    Route::post('manage-bids/hire', [\App\Http\Controllers\Admins\JobPosts\JobBiddingController::class, 'hire'])->name('admin.manage-bids.hire');
    
            //Admins
            Route::get('admins', [AdminsController::class, 'index'])->name('admins.index');
            Route::post('admins', [AdminsController::class, 'storeOrUpdate'])->name('admins.storeOrUpdate');
            Route::get('admins/{admin}', [AdminsController::class, 'edit'])->name('admins.edit');
            Route::delete('admins/{admin}', [AdminsController::class, 'destroy'])->name('admins.delete');
           
            //Users
            Route::get('users/export', [UsersController::class, 'export'])->name('users.export');
            Route::get('users', [UsersController::class, 'index'])->name('users.index');
            Route::delete('users/bulk-delete', [UsersController::class, 'bulkDelete'])->name('users.bulk-delete');
            Route::post('users', [UsersController::class, 'storeOrUpdate'])->name('users.storeOrUpdate');
            Route::get('users/{user}', [UsersController::class, 'edit'])->name('users.edit');
            Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.delete');


            Route::get('users/show/{user}', [UsersController::class, 'show'])->name('users.show');



            //Users Actions
            Route::post('users/updateStatus', UsersStatusUpdateController::class)->name('users.updateStatus');
            //Users Actions Offline Verification
            Route::post('users/offlineVerification', UsersOfflineVerificationUpdateController::class)->name('users.offlineVerification');

            //Enquiry
            Route::get('enquiry', [\App\Http\Controllers\EnquiryController::class, 'index'])->name('enquiry.index');


            //ServiceProviders
            Route::get('serviceproviders/export', [ServiceProvidersController::class, 'export'])->name('serviceproviders.export');
            Route::post('serviceproviders/import', [ServiceProvidersController::class, 'import'])->name('serviceproviders.import');
            Route::get('serviceproviders', [ServiceProvidersController::class, 'index'])->name('serviceproviders.index');
            Route::post('serviceproviders', [ServiceProvidersController::class, 'storeOrUpdate'])->name('serviceproviders.storeOrUpdate');
            Route::delete('serviceproviders/bulk-delete', [UsersController::class, 'bulkDelete'])->name('serviceproviders.bulk-delete');
            Route::get('serviceproviders/{serviceprovider}', [ServiceProvidersController::class, 'edit'])->name('serviceproviders.edit');
            Route::get('serviceproviders/show/{serviceprovider}', [ServiceProvidersController::class, 'show'])->name('serviceproviders.show');
            Route::get('serviceproviders/update/{serviceprovider}', [ServiceProvidersController::class, 'update'])->name('serviceproviders.update');
            Route::get('serviceproviders/billing/{serviceprovider}', [ServiceProvidersController::class, 'billing'])->name('serviceproviders.billing');
            Route::delete('serviceproviders/{serviceprovider}', [ServiceProvidersController::class, 'destroy'])->name('serviceproviders.delete');


        //Categories
            Route::get('categories', [CategoriesController::class, 'index'])->name('categories.index');
            Route::post('categories', [CategoriesController::class, 'storeOrUpdate'])->name('categories.storeOrUpdate');
            Route::get('categories/{category}', [CategoriesController::class, 'edit'])->name('categories.edit');
            Route::delete('categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.delete');

            //Services
            Route::get('services', [ServicesController::class, 'index'])->name('services.index');
            Route::post('services', [ServicesController::class, 'storeOrUpdate'])->name('services.storeOrUpdate');
            Route::get('services/{service}', [ServicesController::class, 'edit'])->name('services.edit');
            Route::delete('services/{service}', [ServicesController::class, 'destroy'])->name('services.delete');



            //Subscription Plans
            Route::get('subscription-plans', [SubscriptionPlansController::class, 'index'])->name('subscription-plans.index');
            Route::post('subscription-plans', [SubscriptionPlansController::class, 'storeOrUpdate'])->name('subscription-plans.storeOrUpdate');
            Route::get('subscription-plans/{plan}', [SubscriptionPlansController::class, 'edit'])->name('subscription-plans.edit');
            Route::delete('subscription-plans/{plan}', [SubscriptionPlansController::class, 'destroy'])->name('subscription-plans.delete');

            //roles & permission
            Route::get('roles-permissions', [RolesPermissionController::class, 'index'])->name('roles-permissions.index');
            Route::post('roles-permissions', [RolesPermissionController::class, 'storeOrUpdate'])->name('roles-permissions.storeOrUpdate');
            Route::get('roles-permissions/{roles}', [RolesPermissionController::class, 'edit'])->name('roles-permissions.edit');
            Route::delete('roles-permissions/{roles}', [RolesPermissionController::class, 'destroy'])->name('roles-permissions.delete');


            //Job Posts
          
    // Naya Bidding Module
   
            Route::get('job-posts', [\App\Http\Controllers\Admins\JobPosts\JobPostsController::class, 'index'])->name('job-posts.index');
            Route::post('job-posts', [\App\Http\Controllers\Admins\JobPosts\JobPostsController::class, 'storeOrUpdate'])->name('job-posts.storeOrUpdate');
            Route::get('job-posts/{job}', [\App\Http\Controllers\Admins\JobPosts\JobPostsController::class, 'edit'])->name('job-posts.edit');
            Route::get('job-posts/show/{job}/{serviceprovider}', [\App\Http\Controllers\Admins\JobPosts\JobPostsController::class, 'show'])->name('job-posts.show');


            //JobPosts-Actions
            Route::post('job-posts/updateAssignedTo', JobPostsAssignedToUpdateController::class)->name('job-posts.updateAssignedTo');

            //Billing - Subscriptions
            Route::get('billing/subscriptions', [\App\Http\Controllers\Admins\BillingSubscriptionsController::class, 'index'])->name('billing.subscriptions.index');
            Route::get('billing/show/{serviceprovider}', [\App\Http\Controllers\Admins\BillingSubscriptionsController::class, 'show'])->name('billing.subscriptions.show');

            //Payment-Requests
            Route::get('billing/payments', [\App\Http\Controllers\Admins\PaymentsController::class, 'index'])->name('billing.payments.index');

            //Payment-Requests
            Route::get('billing/payment-requests', [\App\Http\Controllers\Admins\PaymentsController::class, 'paymentRequest'])->name('billing.payment-requests.index');

            //Reports
            Route::group(['prefix' => 'reports'],function () {
                Route::get('job-accepted-declined/export', [\App\Http\Controllers\Admins\Reports\JobAcceptedDeclinedController::class, 'export'])->name('job-accepted-declined.export');
                Route::get('job-accepted-declined', [\App\Http\Controllers\Admins\Reports\JobAcceptedDeclinedController::class, 'index'])->name('job-accepted-declined.index');
            });

            //Blogs
            Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
            Route::get('blogs/create', [BlogController::class, 'create'])->name('blogs.create');
            Route::get('blogs/edit/{blog}', [BlogController::class, 'edit'])->name('blogs.edit');
            Route::post('blogs/store',[BlogController::class,'store'])->name('blogs.store');
            Route::put('blogs/{blog}/update',[BlogController::class,'update'])->name('blogs.update');
            Route::delete('blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.delete');
            Route::post('blogs/{blog}/status', [BlogController::class, 'status'])->name('blogs.status');
            Route::delete('blogs/media/delete', [BlogController::class, 'destroyMedia'])->name('blogs.media.delete');






            //Settings
            Route::group(['prefix' => 'settings'],function (){
                Route::post('store', [\App\Http\Controllers\Admins\Settings\SettingsController::class, 'storeOrUpdate'])->name('settings.storeOrUpdate');
                Route::get('/',[App\Http\Controllers\Admins\Settings\SettingsController::class,'index'])->name('settings.index');

                //Categories
                Route::get('states', [\App\Http\Controllers\Admins\StatesController::class, 'index'])->name('states.index');
                Route::post('states', [\App\Http\Controllers\Admins\StatesController::class, 'storeOrUpdate'])->name('states.storeOrUpdate');
                Route::get('states/{state}', [\App\Http\Controllers\Admins\StatesController::class, 'edit'])->name('states.edit');
                Route::delete('states/{state}', [\App\Http\Controllers\Admins\StatesController::class, 'destroy'])->name('states.delete');

                //Manage Ads
                Route::get('manage-ads', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'index'])->name('manage-ads.index');
                Route::post('manage-ads', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'storeOrUpdate'])->name('manage-ads.storeOrUpdate');
                Route::get('manage-ads/{advertisement}', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'edit'])->name('manage-ads.edit');
                Route::delete('manage-ads/{advertisement}', [\App\Http\Controllers\Admins\Settings\AdvertisementsController::class, 'destroy'])->name('manage-ads.delete');

                //BusinessValue
                Route::get('business-values', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'index'])->name('business-values.index');
                Route::post('business-values', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'storeOrUpdate'])->name('business-values.storeOrUpdate');
                Route::get('business-values/{value}', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'edit'])->name('business-values.edit');
                Route::delete('business-values/{value}', [\App\Http\Controllers\Admins\Settings\BusinessValueController::class, 'destroy'])->name('business-values.delete');
            });
    });

    //Service Provider
    Route::group(['prefix' => 'service-provider','middleware' => 'service-provider'],function () {
        //Notifications
        Route::get('notifications', [\App\Http\Controllers\ServiceProviders\MyNotificationsController::class, 'index'])->name('service-providers.notifications.index');

        //Profile Settings
        Route::get('profile-settings', [ProfileSettingsController::class, 'index'])->name('profile-settings.index');


        //Job Post Requests
        Route::get('jobs/requests', [\App\Http\Controllers\ServiceProviders\JobPostRequestsController::class, 'index'])->name('service-providers.request-job-posts.index');

        //My Job Posts
        Route::get('jobs/my-jobs', [\App\Http\Controllers\ServiceProviders\MyJobsController::class, 'index'])->name('service-providers.my-jobs.index');
Route::get('jobs/my-jobs/show/{job}', [\App\Http\Controllers\ServiceProviders\MyJobsController::class, 'show'])->name('service-providers.my-jobs.show'); 

        //JobProgress
        Route::get('job-progress', [\App\Http\Controllers\JobProgressController::class, 'index'])->name('job-progress.index');
        Route::post('job-progress', [\App\Http\Controllers\JobProgressController::class, 'storeOrUpdate'])->name('job-progress.storeOrUpdate');
        Route::get('job-progress/{jobProgress}', [\App\Http\Controllers\JobProgressController::class, 'edit'])->name('job-progress.edit');
        Route::delete('job-progress/{jobProgress}', [\App\Http\Controllers\JobProgressController::class, 'destroy'])->name('job-progress.delete');

        //My Job Posts
        Route::get('my-job-posts', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'index'])->name('service-providers.my-job-posts.index');
        Route::post('my-job-posts', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'storeOrUpdate'])->name('service-providers.my-job-posts.storeOrUpdate');
        Route::get('my-job-posts/{job}', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'edit'])->name('service-providers.my-job-posts.edit');
        Route::delete('my-job-posts/{job}', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'destroy'])->name('service-providers.my-job-posts.delete');
       // Route::get('my-job-posts/show/{job}/{serviceprovider}', [\App\Http\Controllers\ServiceProviders\MyJobPostsController::class, 'show'])->name('service-providers.my-job-posts.show');


        //Subscription and Payments
        Route::get('subscriptions', [\App\Http\Controllers\ServiceProviders\ProviderSubscriptionsController::class, 'index'])->name('provider.subscriptions.index');

    });


});
