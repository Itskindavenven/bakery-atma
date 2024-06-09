<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <p>Halo <b>Pegawai </b>{{ $details['name'] }},</p>
    <p>Kami menerima permintaan untuk mereset kata sandi Anda. Silakan klik tautan di bawah ini untuk mereset kata sandi Anda:</p>
    <p>Masukkan kode berikut ketika ganti password <b>{{$details['token']}}</b></p>
    <p><a href="{{ url('reset-password-pegawai/'.$details['token']) }}">Reset Password</a></p>
    <p>Jika Anda tidak melakukan permintaan ini, Anda dapat mengabaikan email ini.</p>
    <p>Terima kasih.</p>
</body>
</html>