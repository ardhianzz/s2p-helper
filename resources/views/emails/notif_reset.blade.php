<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reset['title'] }}</title>
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
<body>
    <h3> Anda Baru Saja Mengganti Password </h3>
    <p> Jika bukan Anda yang melakukan aktivitas ini, sebaiknya segera beritahu Tim IT. </p>

    <p>Berikut Data Aktivitas Anda : </p>

    <table>
        <tr>
            <td style="width: 250px" class="judul"> <b> Alamat IP Local </b> </td> 
            <td> {{ $reset['ip_local'] }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Alamat IP Public </b> </td> 
            <td> {{ $reset['ip_public']->ip }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Alamat IP Public </b> </td> 
            <td> {{ $reset['user_agent'] }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Kota </b> </td> 
            <td> {{ $reset['ip_public']->city }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Negara </b> </td> 
            <td> {{ $reset['ip_public']->country }}</td>
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