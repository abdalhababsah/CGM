<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Us Message</title>
    <style>
        /* Reset styles */
        body, p, h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .content {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: rgb(151, 29, 37);
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .header h1 {
            color: #ffffff;
            margin-top: 10px;
            font-size: 24px;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            margin: 8px 0;
            font-size: 16px;
        }
        .details p strong {
            color: rgb(151, 29, 37);
        }
        .message {
            font-size: 16px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #777777;
            font-size: 12px;
            margin-top: 30px;
        }
        .footer p {
            margin: 5px 0;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 20px;
            }
            .header h1 {
                font-size: 20px;
            }
            .details p {
                font-size: 14px;
            }
            .message {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <!-- Header Section with Logo -->
            <div class="header">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('user/img/logo-white-01.svg') }}" alt="{{ config('app.name') }} Logo">
                </a>
                <h1>New Contact Us Message</h1>
            </div>

            <!-- Contact Details -->
            <div class="details">
                <p><strong>Name:</strong> {{ $data['name'] }}</p>
                <p><strong>Email:</strong> {{ $data['email'] }}</p>
            </div>

            <!-- Message Content -->
            <p class="message">
                {{ $data['message'] }}
            </p>

            <!-- Footer Section -->
            <div class="footer">
                <p>{{ config('app.name') }} | 1234 Street Address, City, State, ZIP</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>