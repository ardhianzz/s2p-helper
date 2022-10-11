<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT SUMBER SEGARA PRIMADAYA</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
        }
        .judul {
            background-color: #363b36;
            color: white;
        }
    </style>
</head>
@foreach ($reminders as $d)
    
{{-- Yth, {{ $d->user->pegawai->nama }} --}}
Yth, {{ $d->user->pegawai->nama }} 
<br>
<br>
Berikut adalah informasi terkait catatan anda yang telah mendekati tanggal jatuh tempo :
<br>
<br>
@endforeach
<body>
    <table>
        <tr>
            <td style="width: 250px" class="judul"> <b> Nama Catatan </b> </td> 
            @foreach ($reminders as $d)
                
            <td> {{ $d->nama }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="judul"> <b>Berlaku</b> </td>
            @foreach ($reminders as $d)
                @if ($d->from == null && $d->to == null)
                    <td> - </td>
                @else
                    <td>{{ tanggl_id(($d->from)) }} - {{ tanggl_id(($d->to)) }} </td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="judul"> <b>Tanggal Expired</b> </td>
            @foreach ($reminders as $d)
                @if ($d->tanggal_expired == null)
                    <td> - </td>
                @else
                    <td> {{ tanggl_id(($d->tanggal_expired)) }} </td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="judul"> <b>Tanggal Pengingat</b> </td>
            @foreach ($reminders as $d)
                
            <td> {{ tanggl_id(($d->tanggal_pengingat)) }} </td>
            @endforeach
        </tr>
        <tr>
            <td class="judul"> <b>Email</b> </td>
            @foreach ($reminders as $d)
                
            <td> {{ $d->email }} </td>
            @endforeach
        </tr>
        <tr>
            <td class="judul"> <b>Keterangan / Deskripsi</b> </td>
            @foreach ($reminders as $d)
                
            <td>{{ $d->keterangan }}</td>
            @endforeach
        </tr>
    </table>

    <p>Salam,
        <br>
        <br>
        <br>
    IT Support
    </p>
    
</body>
</html>
