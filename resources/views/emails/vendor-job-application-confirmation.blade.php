@component('emails.layouts.index', [
    'heading' => 'Your Application for '. $job->title .' is Received',
    'subject' => 'Your Application for '. $job->title .' is Received',
    'customFooter' => "
        Best wishes,<br>
        The CtrlF Team<br>
        Your Partner in Retail Excellence
    "
])

    <p>Dear <strong>{{ $notifiable->name }}</strong>,</p>

    <p>We've received your application for the <strong>{{ $job->title }}</strong> project posted by <strong>{{ $job->postedBy->name }}</strong>.</p>

    <p><strong>Application Details:</strong></p>
    <ul>
        <li><strong>Project ID:</strong> JB-{{ $job->id }}</li>
        <li><strong>Submitted on:</strong> {{ \Carbon\Carbon::parse($job->updated_at)->format('d-m-Y h:i A') }}</li>
        <li><strong>Current Status:</strong> Under Review</li>
    </ul>

    <p><strong>What's Next:</strong></p>
    <ul>
        <li>Our AI will match your profile with project requirements</li>
        <li>Client will be notified of your application</li>
        <li>Expect an update within 48–72 hours</li>
    </ul>

    <p><strong>Pro Tip:</strong> Increase your chances by:</p>
    <ul>
        <li>Highlighting relevant past projects</li>
        <li>Ensuring your profile is 100% complete</li>
        <li>Responding quickly to client queries</li>
    </ul>

    <p>Stay patient and positive!</p>


@endcomponent
