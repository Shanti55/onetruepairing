@component('emails.layouts.index', [
    'heading' => 'Your CtrlF Profile is Now Verified',
    'subject' => 'Congratulations! Your CtrlF Profile is Now Verified',
    'customFooter' => "
        Welcome to the future of retail services,<br>
        The CtrlF Team
    "
])

    <p>Dear <strong>{{ $user->name }}</strong>,</p>

    <p>Great news! Your profile on <strong>CtrlF</strong> has been fully verified. You're now a certified service provider ready to transform retail spaces across India.</p>

    <p><strong>Your Verified Status Means:</strong></p>
    <ul>
        <li>Access to premium retail brand projects</li>
        <li>Increased visibility in our marketplace</li>
        <li>Credibility with potential clients</li>
        <li>Priority in project matching</li>
    </ul>

    <p><strong>Next Steps:</strong></p>
    <ul>
        <li>Complete your service listing</li>
        <li>Upload your best project portfolio</li>
        <li>Set your availability</li>
        <li>Start applying to projects</li>
    </ul>

    <p style="text-align: center;"><strong>Pro Tip:</strong> Vendors with complete profiles get 3x more project inquiries!</p>

    <p style="text-align: center;">Need help maximizing your profile?<br>
        Call: <a href="tel:918800500263">918800500263</a> | Email: <a href="mailto:support@ctrlf.co.in">support@ctrlf.co.in</a>
    </p>

@endcomponent
