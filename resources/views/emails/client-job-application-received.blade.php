@component('emails.layouts.index', [
    'heading' => 'New Application Received for '. $job->title,
    'subject' => 'New Application Received for '. $job->title,
    'customFooter' => "
        Regards,<br>
        The CtrlF Team<br>
        Connecting Retail Excellence
    "
])

    <p>Dear {{ $job->postedBy->name }},</p>

    <p>A service provider has applied to your <strong>{{ $job->title }}</strong> project on CtrlF.</p>

    <h4>Vendor Profile Highlights:</h4>
    <ul>
        <li><strong>Name:</strong> {{ $job->assignedTo->name }}</li>
        <li><strong>Specialization:</strong> {{ $services->implode(', ') }}</li>
        <li><strong>Verified Status:</strong> ✓</li>
{{--        <li><strong>Past Project Success Rate:</strong> {{ $vendor_success_rate }}%</li>--}}
    </ul>

    <h4>Quick Actions:</h4>
    <ol>
        <li>Review vendor profile</li>
        <li>Check past project portfolio</li>
        <li>Initiate conversation</li>
        <li>Compare with other applicants</li>
    </ol>

    <p><strong>Pro Tip:</strong> Our platform allows easy vendor comparison and direct messaging.</p>

    <p>Login to your CtrlF dashboard to take the next steps.</p>

    <p>Best regards,<br>
        The CtrlF Team</p>



@endcomponent
