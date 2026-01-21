@component('emails.layouts.index', [
    'heading' => 'Opportunity Knocks! New Job Posted in Your Service Categories',
    'subject' => 'Opportunity Knocks! New Job Posted in Your Service Categories',
    'customFooter' => "
        Best Regards,<br>
        The CtrlF Team
    "
])

    <p>Dear {{ $notifiable->name }},</p>

    <p>A new project titled <strong>{{ $job->title }}</strong> has just been posted on CtrlF that matches your service categories.</p>

    <h4>Project Details:</h4>
    <ul>
        <li><strong>Project ID:</strong> JB-{{ $job->id }}</li>
        <li><strong>Posted on:</strong> {{ \Carbon\Carbon::parse($job->created_at)->format('d-m-Y h:i A') }}</li>
        <li><strong>Customer Location:</strong> {{ $job->location ?? 'N/A' }}</li>
        <li><strong>Category:</strong> {{ implode(', ', $job->categories->pluck('name')->toArray()) }}</li>
    </ul>

    <p style="text-align: center;">Need help?<br>
        <a href="mailto:support@ctrlf.co.in">support@ctrlf.co.in</a> | 918800500263</p>



@endcomponent
