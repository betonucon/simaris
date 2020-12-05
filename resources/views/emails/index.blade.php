<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Transaksi EB17</title>
        <style>
            .head{
                width:100%;
                padding:5px;
                border:dotted 1px #000;
            }
            td{
                border:dotted 1px #000;
                font-size:12px;
            }
        </style>
    </head>
    <body>
        <div class="head">
            <center><img src="http://uconbeton.com/logo.jpg" width="50%"></center>
            <hr style="border:dotted 1px #000">
            <h4>Hai, {{ $data['name'] }}</h4>
            <table width="100%" >
                <tr>
                    <td width="30%"><b>Nomor Transaksi</b></td>
                    <td>{{ $data['notransaksi'] }}</td>
                </tr>
                <tr>
                    <td><b>Tanggal Transaksi</b></td>
                    <td>{{ $data['tanggal'] }}</td>
                </tr>
                <tr>
                    <td><b>Keterangan</b></td>
                    <td>{{ $data['keterangan'] }}</td>
                </tr>
                <tr>
                    <td><b>Harga</b></td>
                    <td>{{ uang($data['harga']) }}</td>
                </tr>
                
            </table><br><br>
            <i><font size="1"><b>Kumpulkan kupon ini sebanyak 10x, dan tukarkan kupon untuk mendapatkan diskon 50%</b></font></i>
        </div>
        
    </body>
</html>