<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Perubahan Email</title>
</head>
<body>
    <h1>Halo {{ $userName }},</h1>
    <p>Kami menerima permintaan untuk mengubah alamat email akun Anda. Untuk memverifikasi perubahan ini, silakan klik tombol di bawah:</p>
    <br>
    <a href="{{ $verificationLink }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Verifikasi Alamat Email Baru</a>
    <br>
    <p>Link verifikasi ini akan kedaluwarsa dalam 60 menit.</p>
    <p>Jika Anda tidak melakukan perubahan ini, tidak ada tindakan lebih lanjut yang diperlukan.</p>
    <p>Terima kasih,<br>Tim {{ config('app.name') }}</p>
    <br>
    <p>Jika Anda mengalami kesulitan mengklik tombol "Verifikasi Alamat Email Baru", salin dan tempel URL di bawah ini ke browser Anda:<br>
        <a href="{{ $verificationLink }}">{{ $verificationLink }}</a></p>
</body>
</html>