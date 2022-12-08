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
        h1{ 
            font-family: "Brush Script MT",
            cursive; font-size: 20px; 
            font-style: normal; 
            font-variant: normal; 
            font-weight: 700; 
            line-height: 26.4px;
            color: #063970;
        }
        .d1 {
             font-family: "Bookman Old Style"; 
             font-size: 14px; 
             font-style: normal; 
             font-variant: normal; 
             font-weight: 700; 
             line-height: 26.4px; 
             color: #063970;
        }
        .d2 {
            font-family: "Arial"; 
             font-size: 10px; 
             font-style: normal; 
             font-variant: normal; 
             font-weight: 400; 
             line-height: 20px; 
             color: #063970;
        }
        .d3 {
             font-family: 'MV Boli';
             font-size: 14px; 
             font-style: italic; 
             font-variant: normal; 
             font-weight: 400; 
             line-height: 20px; 
             color: #078507;
        }
        .ijo{
        color: #078507;
        }
        .d4{
             font-family: "Calibri"; 
             font-size: 10px; 
             color: #063970;
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
   
    <p>Regards,
        <br>
    </p>
    <h1>IT Support</h1>
    <a class="d1">
        PT Sumber Segara Primadaya
        <br>
        <a class="d2">Treasury Tower, 39th Fl. District 8 SCBD Lot 28 - Jl. Jend. Sudirman Kav. 52-53
        <br>
        Jakarta, 12190, Indonesia - ahone : +62 21 2912 6888 /  Fax : +62 21 2912 6886
    	</a>
    </a>
    <br>
    <span style="font-family:Webdings" class="ijo">&#x00fd;</span>
    <a class="d3">
    <a class="d3"> Please consider the environment before printing this email</a>
    <br>
    <a class="d4">
    This email may contain information which is privileged and/ or confidential. If you are not the intended recipient of this e-mail, notify us immediately by e-mail or telephone and delete this e-mail immediately without copying or disclosing its contents to any other person. The sender of this email shall not be responsible nor liable for any errors or omissions in the content on this e-mail as secure or error free e-mail transmission cannot be guaranteed. Information could be intercepted, corrupted, lost, destroyed, arrive late or incomplete or contain viruses. This email is strictly for the eyes of the intended recipient, and any other party (which are not recipient to this email) that have been approved in writing by the sender. Any disclosure, reproduction, distribution, or any action which abuse the intention of this e-mail in connection with its contents or any attachments by anyone other than the named recipient is strictly prohibited. Any loss, claim, lawsuit or other form of consequences that occur as the result of ignoring this disclaimer is beyond the responsibility of the sender and/or PT Sumber Segara Primadaya.
    </a>
    
</body>
</html>