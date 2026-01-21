@component('emails.layouts.index', [
    'heading' => 'Your Registration is Received!',
    'subject' => 'Welcome to CtrlF - Your Registration is Received!',
    'customFooter' => "
        Best Regards,<br>
        The CtrlF Team<br>
        Transforming Retail Services, Empowering Businesses
    "
])

    <p>Dear, {{$user->name}}</p>

    <p>Thank you for registering with <strong>CtrlF</strong>, India's premier retail services marketplace. We're excited to have you on board!</p>

    <p>Your registration has been received and is now under review. Here's what happens next:</p>
    <ul style="padding-left: 20px; margin: 10px 0;">
        <li>Our team will verify your business details</li>
        <li>We'll assess your professional credentials</li>
        <li>Expect a verification update within 2–3 business days</li>
    </ul>

    <p><strong>What you can do now:</strong></p>
    <ul style="padding-left: 20px; margin: 10px 0;">
        <li>Complete your profile with detailed information</li>
        <li>Prepare your portfolio and certifications</li>
        <li>Get ready to connect with premium retail brands</li>
    </ul>

{{--    <p style="text-align: center;"><strong>Registration ID:</strong></p>--}}

    <p style="text-align: center;"><strong>Questions?</strong> Our support team is ready to help:<br>
        <a href="mailto:support@ctrlf.co.in">support@ctrlf.co.in</a> | <a href="tel:+918800500263">+91 8800500263</a></p>

@endcomponent
