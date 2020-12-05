<html>
    <head>
        <title>DAFTAR PRODUK</title>
        <style>
            html{
                margin:10px;
            }
            th{
                border:solid 1px #fff;
                background:aqua;
                padding-left:10px;
                font-size:12px;
            }
            td{
                border-bottom:solid 1px aqua;
                padding-left:10px;
                border-bottom-style: dotted;
                font-size:12px;
            }
        </style>
    </head>
    <body>
        <table width="100%" style="border-collapse:collapse">
            <tr>
                <th width="5%">No</th>
                <th width="8%">Kode</th>
                <th>Nama</th>
                <th width="15%">Kategori</th>
                <th width="10%">Harga</th>
                <th width="16%">Jual</th>
                <th width="8%">Satuan</th>
            </tr>
            
                @foreach($data as $no=>$data)
                    
                    <tr>
                        <td>{{$no+1}}</td>
                        <td>{{$data['kode']}}</td>
                        <td>{{$data['name']}}</td>
                        <td>{{cek_kategori($data['kategori_id'])}}</td>
                        <td>{{uang($data['harga'])}}</td>
                        <td>{{uang($data['harga_jual'])}}</td>
                        <td>{{$data['satuan']}}</td>
                    </tr>
                    
                @endforeach
            
        </table>
    </body>
</html>