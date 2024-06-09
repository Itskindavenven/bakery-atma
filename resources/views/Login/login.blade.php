<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atma Bakery</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
            border: 1px solid #ddd;
            background: rgba(255, 255, 255, 0.9);
            min-height: 400px;
            padding: 30px;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        #login-box .logo {
            margin-bottom: 20px;
            text-align: center;
        }

        #login-box .logo-caption {
            font-family: 'Cambria', serif;
            font-size: 36px;
            color: #8B4513;
            margin: 0;
        }

        #login-box .controls {
            padding-top: 30px;
        }

        #login-box .controls input {
            border-radius: 0px;
            background: #f0f0f0;
            border: 1px solid #ccc;
            color: #333;
            font-family: 'Nunito', sans-serif;
        }

        #login-box .controls input:focus {
            box-shadow: none;
            border-color: #8B4513;
        }

        #login-box .controls input:first-child {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        #login-box .controls input:last-child {
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        #login-box button.btn-custom {
            border-radius: 5px;
            margin-top: 8px;
            background: #8B4513;
            border-color: #8B4513;
            color: white;
            font-family: 'Nunito', sans-serif;
        }

        #login-box button.btn-custom:hover {
            background: #A0522D;
            border-color: #A0522D;
        }

        .btn-link {
            color: #8B4513;
        }

        .btn-link:hover {
            color: #A0522D;
        }

        #particles-js {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: 50% 50%;
            position: fixed;
            top: 0px;
            z-index: 1;
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
            <form method="post" action="{{ route('action-login') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="text" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-custom btn-block">Login</button>
                <hr>
                <button type="button" class="btn btn-link"><a class="nav-link" href="{{ route('reset-email-cust')}}">Forgot Password Customer?</a></button>
                <button type="button" class="btn btn-link"><a class="nav-link" href="{{ route('reset-email-peg')}}">Forgot Password Employee?</a></button>
                <p class="text-center mt-5"><a href="{{ route('register') }}">Register Here</a></p>
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
            // Mengganti URL ke halaman login
            window.history.pushState(null, "", "/");
        }
        window.onpopstate = function () {
            // Mengganti URL ke halaman login setiap kali pengguna mencoba untuk kembali
            window.history.pushState(null, "", "/");
        }
    </script>
</body>
</html>
