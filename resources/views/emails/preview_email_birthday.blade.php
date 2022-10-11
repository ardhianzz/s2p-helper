<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT SUMBER SEGARA PRIMADAYA</title>
</head>
@foreach ($reminders as $d)
    
Yth, {{ $d->user->pegawai->nama }} 
<br> 
<br>
<p> Selamat Ulang Tahun kepada Bpk/Ibu {{ $d->user->pegawai->nama }}. <br>
Semoga panjang umur, diberikan rezeki yang melimpah, sehat dan sukses serta bahagia selalu bersama keluarga. <br>
Aamiin YRA. </p>
<br>
<p>Salam,
    <br>
    <br>
    <br>
IT Support
</p>

@endforeach
<body>
</body>
</html>
