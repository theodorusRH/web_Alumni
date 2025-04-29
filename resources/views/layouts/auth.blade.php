<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style-conquer.css') }}" rel="stylesheet" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #ffffff;
        }
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center; /* horizontal center */
            /* align-items: center; */
            background-color: #ffffff;
            align-items: flex-start;
            padding-top: 60px;
            padding-bottom: 60px;
            overflow-y: auto;
        }
        .login-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

    </style>
</head>
<body>
    @yield('content')

    <script src="{{ asset('assets/plugins/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
