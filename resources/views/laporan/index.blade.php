@extends('layouts.app_top')
<style>
    th{
        font-size:12px;
        background:#b0e6e6;
    }
    td{
        font-size:12px;
    }
    .ttd{
        border:solid 10x #000;
    }
</style>
@section('content')
<section class="content-header">
    <h1>
        Laporan Transaksi E-Kasir
        <small>EB_17</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Layout</a></li>
        <li class="active">Top Navigation</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" style="margin-bottom:1%">
              
                  <input type="text" name="mulai" value="{{$mulai}}" id="datepicker" style="width:20%;display:inline" class="form-control" placeholder="Search">
                  <input type="text" name="sampai" value="{{$sampai}}" id="datepicker2" style="width:20%;display:inline" class="form-control" placeholder="Search">
                  <span class="btn btn-default" onclick="cari()"><i class="fa fa-search"></i></span>
                  <span class="btn btn-success" onclick="cetak_pdf()"><i class="fa fa-print"></i></span>
                 
                
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" id="tampilkan">
              
                
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>


<div class="modal modal-fullscreen fade" id="modalloading" >
    <div class="modal-dialog" style="margin-top: 15%;">
        <div class="modal-content" style="background: transparent;">
            
            <div class="modal-body" style="text-align:center">
                <img src="{{url(url_link().'/img/loading.gif')}}" width="10%">
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('datatable')
    <script>
        function tambah(){
            $('#modal-default').modal({backdrop: 'static', keyboard: false});
        }
        function cetak_pdf(){
            var mulai=$('#datepicker').val();
            var sampai=$('#datepicker2').val();
            window.open("{{url('cetak_pdf')}}/"+mulai+"/"+sampai,'_blank');
        }
        function cari(){
            var mulai=$('#datepicker').val();
            var sampai=$('#datepicker2').val();
            // window.location.assign("{{url('laporan')}}?mulai="+mulai+"&sampai="+sampai);
            $("#tampilkan").load("{{url('view_laporan')}}?mulai="+mulai+"&sampai="+sampai);
        }

        //$('#modalcetak').modal({backdrop: 'static', keyboard: false});
       
        $(document).ready(function() {
            var mulai=$('#datepicker').val();
            var sampai=$('#datepicker2').val();
            $.ajax({
               type: 'GET',
               url: "{{url('view_laporan')}}?mulai="+mulai+"&sampai="+sampai,
               data: "id=id",
               beforeSend: function(){
                    $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    
               },
               success: function(msg){
                    $('#modalloading').modal('hide');
                   $("#tampilkan").html(msg);
                  
               }
           });

        });

        

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    
@endpush