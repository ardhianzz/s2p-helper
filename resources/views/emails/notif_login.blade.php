<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['title'] }}</title>
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
    <h3> Anda Baru Saja Login </h3>
    <p> Jika bukan Anda yang memberikan akses, sebaiknya periksa aktivitas ini dan segera beritahu Tim IT. </p>

    <p>Berikut Data Login Anda : </p>

    <table>
        <tr>
            <td style="width: 250px" class="judul"> <b> Alamat IP Local </b> </td> 
            <td> {{ $details['ip_local'] }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Alamat IP Public </b> </td> 
            <td> {{ $details['ip_public']->ip }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Waktu </b> </td> 
            <td> {{ $details['waktu'] }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> User Agent </b> </td> 
            <td> {{ $details['user_agent'] }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Kota </b> </td> 
            <td> {{ $details['ip_public']->city }}</td>
        </tr>
        <tr>
            <td style="width: 250px" class="judul"> <b> Negara </b> </td> 
            <td> {{ $details['ip_public']->country }}</td>
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