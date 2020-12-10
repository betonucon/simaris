<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan risiko bisnis ".$judul.".xls");
?>
<html>
    <head>
        <title>Laporan risiko bisnis {{$judul}}</title>
        <style>
            
        </style>
    </head>
    <body>
        {!!$tampil!!}
    </body>
</html>