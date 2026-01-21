@component('emails.layouts.index', [
    'heading' => 'Your Project '. $job->title .' is Live on CtrlF',
    'subject' => 'Your Project '. $job->title .' is Live on CtrlF',
    'customFooter' => "
        Best Regards,<br>
        The CtrlF Team<br>
        Your Retail Services Simplified
    "
])

    <p>Dear {{ $job->postedBy->name }},</p>

    <p>Your project <strong>{{ $job->title }}</strong> has been successfully posted on CtrlF. We're working to connect you with the best service providers.</p>

    <h4>What Happens Next:</h4>
    <ul>
        <li>Our AI matching system identifies ideal vendors</li>
        <li>Verified service providers will review your project</li>
        <li>You'll receive applications within 24–48 hours</li>
        <li>Easy comparison and selection tools available</li>
    </ul>

    <h4>Project Details Confirmed:</h4>
    <ul>
        <li><strong>Project ID:</strong> JB-{{ $job->id }}</li>
        <li><strong>Posted on:</strong> {{ \Carbon\Carbon::parse($job->created_at)->format('d-m-Y h:i A') }}</li>
        <li><strong>Estimated Vendor Match:</strong> 5–10 professionals</li>
    </ul>

    <h4>Quick Tips:</h4>
    <ul>
        <li>Respond promptly to vendor applications</li>
        <li>Use our detailed vendor comparison tools</li>
        <li>Check vendor ratings and past project history</li>
    </ul>

    <p style="text-align: center;">Need assistance?<br>
        <a href="mailto:support@ctrlf.co.in">support@ctrlf.co.in</a> | 918800500263</p>


@endcomponent
