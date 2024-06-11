<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atma Bakery - Registration</title>
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
            color: white;
            font-family: 'Nunito', sans-serif;
        }

        #login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 520px;
            margin: 0 auto;
            border: 1px solid #333;
            background: rgba(48, 46, 45, 0.85);
            min-height: 500px;
            padding: 20px;
            z-index: 9999;
            border-radius: 10px;
        }

        #login-box .logo {
            background-color: #f8f8f8;
            border: 2px solid #e2e2e2;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        #login-box .logo-caption {
            font-family: 'Cambria', sans-serif;
            font-size: 36px;
            color: #8B4513;
            margin: 0;
        }

        #login-box .tweak {
            color: #A52A2A;
            font-weight: bold;
        }

        #login-box .controls input,
        #login-box .controls select {
            border-radius: 5px;
            background: rgb(98, 96, 96);
            border: 0px;
            color: white;
            margin-bottom: 10px;
            font-family: 'Nunito', sans-serif;
        }

        #login-box .controls input:focus,
        #login-box .controls select:focus {
            box-shadow: none;
        }

        #login-box .controls label {
            color: #ff5252;
            font-weight: bold;
        }

        #login-box button.btn-custom {
            border-radius: 5px;
            margin-top: 10px;
            background: #ff5252;
            border-color: rgba(48, 46, 45, 1);
            color: white;
            font-family: 'Nunito', sans-serif;
            width: 100%;
        }

        #login-box button.btn-custom:hover {
            transition: all 500ms ease;
            background: rgba(48, 46, 45, 1);
            border-color: #ff5252;
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
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="post" action="{{ route('action-register-peg') }}">
                @csrf
                <div class="form-group controls">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input class="form-control" type="text" name="nama_lengkap" placeholder="Nama Lengkap" required value="{{ old('nama_lengkap') }}">
                </div>
                <div class="form-group controls">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username" required value="{{ old('username') }}">
                </div>
                <div class="form-group controls">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="Enter Tanggal Lahir">
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group controls">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="form-group controls">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group controls">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="id_role">
                        @foreach($roles as $role)
                        <option value="{{ $role->id_role }}">{{ $role->nama_role }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-custom">
                    <i class="fa fa-user"></i> Register
                </button>
                <hr>
                <p class="text-center">
                    Cancel? <a href="{{ route('index-pegawai') }}" style="color: #ff5252;">Back</a>
                </p>
            </form>
        </div>
    </div>
    <div id="particles-js"></div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
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
