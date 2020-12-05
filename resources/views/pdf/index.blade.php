    
<style> 
    table{
        border-collapse:collapse;
        
    }
    html{
        margin:3%;
    }
    th{border:solid 1px #000;font-size:12px;text-align:center;padding:4px;}   
    td{border:solid 1px #000;font-size:12px;padding:4px;}   
</style>   
    <center><img src="{{url(url_link().'/img/logo.jpg')}}" width="30%" ></center><hr style="border:dotted 1px #000">
    <h4>Total Transaksi :{{uang(total_transaksi($mulai,$sampai))}}</h4><br>
    <table class="table table-hover" width="100%">
        <tr>
            <th width="5%">No</th>
            <th width="15%">No Voucher</th>
            <th width="25%">Nama Konsumen</th>
            <th>Keterangan</th>
            <th width="10%">Harga</th>
            <th width="10%">Tanggal</th>
        </tr>
        
        @foreach($data as $no=>$o)
                
                <tr>
                    <td>{{($no+1)}}</td>
                    <td>{{$o['notransaksi']}}</td>
                    <td>{{$o['name']}}</td>
                    <td>{{$o['keterangan']}}</td>
                    <td>{{uang($o['harga'])}}</td>
                    <td>{{$o['tanggal']}}</td>
                    </tr>
        @endforeach
    </table>