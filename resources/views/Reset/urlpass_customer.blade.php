<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Atma Bakery</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body,
        html {
            height: 100%;
            background-repeat: no-repeat;
            background: black;
            position: relative;
            background-image: url('/img/atmabakery.jpg');
            background-size: cover;
            background-position: center;
        }

        #login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            margin: 0 auto;
            border: 1px solid black;
            background: rgba(48, 46, 45, 0.8);
            min-height: 400px;
            padding: 30px;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .logo {
            background-color: #f8f8f8;
            border: 2px solid #e2e2e2;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .logo-caption {
            font-family: 'Cambria', sans-serif;
            font-size: 36px;
            color: #8B4513;
            margin: 0;
        }

        .tweak {
            color: #A52A2A;
            font-weight: bold;
        }

        .form-group label {
            color: white;
        }

        .form-group input {
            background: rgb(98, 96, 96);
            border: 0;
            color: white;
            border-radius: 5px;
        }

        .form-group input:focus {
            box-shadow: none;
            border: 1px solid #ff5252;
        }

        .btn-custom {
            border-radius: 5px;
            background: #ff5252;
            border: none;
            color: white;
            font-family: 'Nunito', sans-serif;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background: #e04b4b;
        }

        .alert-danger {
            background: #ff5252;
            border: none;
            color: white;
        }

        .invalid-feedback {
            color: #ff5252;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="login-box">
            <div class="logo">
                <h1 class="logo-caption">Atma Bakery</h1>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    <b>Oops!</b> {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('reset-cust') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="token">Token:</label>
                    <input type="text" class="form-control @if($errors->has('token')) is-invalid @endif" id="token" name="token" value="{{ old('token') }}">
                    @if($errors->has('token'))
                        <div class="invalid-feedback">{{ $errors->first('token') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control @if($errors->has('new_password')) is-invalid @endif" id="new_password" name="new_password">
                    @if($errors->has('new_password'))
                        <div class="invalid-feedback">{{ $errors->first('new_password') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" class="form-control @if($errors->has('confirm_password')) is-invalid @endif" id="confirm_password" name="confirm_password">
                    @if($errors->has('confirm_password'))
                        <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-custom">Reset Password</button>
            </form>
        </div>
    </div>
    <div id="particles-js"></div>
    <!-- jQuery Library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <!-- Popper JS-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Latest Compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function () {
            window.history.pushState(null, "", "/");
        }
        window.onpopstate = function () {
            window.history.pushState(null, "", "/");
        }
    </script>
</body>
</html>
