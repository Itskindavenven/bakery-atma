<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atma Bakery - Verifikasi Berhasil</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            background: black;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .container {
            text-align: center;
            background: rgba(48, 46, 45, 1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            font-family: 'Cambria', sans-serif;
            color: #8B4513;
            margin-bottom: 20px;
        }
        .container p {
            font-family: 'Nunito', sans-serif;
            color: #FFFFFF;
            font-size: 18px;
        }
        .btn-custom {
            background: #ff5252;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background: rgba(48, 46, 45, 1);
            color: #ff5252;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Verifikasi Berhasil</h1>
        <p>Akun anda sudah aktif. Terima kasih telah melakukan verifikasi email.</p>
        <a href="{{ route('login') }}" class="btn btn-custom">Login Sekarang</a>
    </div>
</body>

</html>
