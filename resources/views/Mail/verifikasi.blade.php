<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Akun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h3 {
            text-align: center;
            color: #333333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table td, table th {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .link {
            text-align: center;
            margin-top: 20px;
        }

        .link a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifikasi Akun</h1>
        <p>Halo <strong>{{ $details['username'] }}</strong>,</p>
        <p>Anda telah melakukan registrasi akun dengan menggunakan email ini.</p>
        
        <h3>Berikut adalah data anda:</h3>
        <table>
            <tr>
                <th>Username</th>
                <td>{{ $details['username'] }}</td>
            </tr>
            <tr>
                <th>Website</th>
                <td>{{ $details['website'] }}</td>
            </tr>
            <tr>
                <th>Tanggal Register</th>
                <td>{{ $details['datetime'] }}</td>
            </tr>
        </table>
        
        <div class="link">
            <h3>Buka link berikut untuk melakukan verifikasi akun:</h3>
            <a href="{{ $details['url'] }}" style="background-color: #007bff;">Verifikasi Akun</a>
        </div>

        <p>Terima kasih telah melakukan registrasi.</p>
    </div>
</body>
</html>