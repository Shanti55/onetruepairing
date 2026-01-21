<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Notification' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff;
            max-width: 640px;
            margin: 30px auto;
            padding: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .header {
            background-color: #3626cd;
            color: white;
            padding: 30px 20px 40px 20px;
            text-align: center;
            position: relative;
        }

        .logo-wrapper {
            position: relative;
            text-align: center;
            margin-top: -40px;
            z-index: 10;
        }

        .logo-circle {
            display: inline-block;
            background: white;
            border-radius: 50%;
            padding: 16px;
        }

        .logo-circle img {
            width: 100px;
            height: auto;
            display: block;
        }

        .inquiry-box {
            background-color: white;
            padding: 30px 20px;
        }

        .inquiry-box h2 {
            margin: 0;
            color: #000;
            font-size: 20px;
        }

        .inquiry-box p {
            color: #555;
            margin: 5px 0 20px 0;
            font-size: 14px;
        }

        .cta-button {
            background-color: #ff9000;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
        }

        .footer {
            background: #f1f1f1;
            padding: 20px;
            font-size: 13px;
            color: #777;
            text-align: center;
        }

        .footer a {
            color: #1d72b8;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="logo-wrapper" style="position: relative; text-align: center; z-index: 2; margin-top: 10px;">
        <div class="logo-circle">
            <img src="{{ $setting->logo }}" alt="ctrlF">
        </div>
    </div>

    <div class="header" style="background-color: #3626cd; margin-top: -25px;">
        <h1>{{ $heading ?? 'Hello!' }}</h1>
    </div>

    <div class="inquiry-box">
        {!! $slot !!}
    </div>

    @if(!empty($customFooter))
        <div class="footer">
            {!! $customFooter !!}
        </div>
    @else
        <div class="footer">
            Best Regards,<br>
            The CtrlF Team<br>
            Transforming Retail Services, Empowering Businesses
        </div>
    @endif

</div>

</body>
</html>
