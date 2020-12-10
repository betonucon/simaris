<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan risiko bisnis.xls");
?>
<html>
    <head>
        <title>Laporan risiko bisnis</title>
        <style>
            
        </style>
    </head>
    <body>
        {!!$tampil!!}
    </body>
</html>