@extends('layouts.app')
<style>
    th{
        font-size:12px;
        background:#b0e6e6;
        border:solid 1px #000;
        text-align:center;
        padding:10px;
        text-transform:uppercase;
    }
    td{
        font-size:12px;
        border:solid 1px #d1d1d6;
        padding:3px;
    }
    .ttd{
        font-size:12px;
        border:solid 1px #d1d1d6;
        padding:5px;
    }
    .form-group {
    
}
</style>
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            
            <div class="box-header" style="margin-bottom:1%">
                
              <h3 class="box-title">
                <span class="btn btn-success btn-sm" onclick="cetak({{$unit_id}})"><i class="fa fa-clone"></i> Export To Excel</span>
                <!-- <span class="btn btn-primary btn-sm" onclick="importdata()"><i class="fa fa-clone"></i> Import</span> -->
                </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 400px;">
                  <select name="table_search" style="display:inline" id="periode" onchange="cari(this.value)" class="form-control pull-right" placeholder="Search">
                  <option value="">Pilih Priode</option>
                            @foreach(periode() as $peri)
                                <option value="{{$peri['id']}}" @if($periode==$peri['id']) selected @endif >[{{$peri['tahun']}}] {{$peri['name']}}</option>
                            @endforeach
                  </select>
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" ><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" id="tampilkan" style="padding:100px">
              
                
             
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
        function importdata(){
            $('#modal-import').modal({backdrop: 'static', keyboard: false});
        }

        
       
       
        $(document).ready(function() {
            var periode=$('#periode').val();
            $.ajax({
               type: 'GET',
               url: "{{url('laporan_risiko/view_data_pimpinansubdit?unit='.$unit_id)}}&periode="+periode,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                    $('#modalloading').modal('hide');
                    $("#tampilkan").html(msg);
                  
               }
           });
            

        });

        function cari(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('laporan_risiko/view_data_pimpinansubdit?unit='.$unit_id)}}&periode="+a,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                   $("#tampilkan").html(msg);
                  
               }
           });
            
        }

        

        function cetak(a){
            var periode=$('#periode').val();
            window.open("{{url('excel_laporan_risiko_subdit')}}?unit="+a+"&periode="+periode, 'download');
            
        }

        function simpan_data(){
            var form=document.getElementById('mysimpan_data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/risiko/simpan')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(msg){
                        if(msg=='ok'){
                            location.reload();
                               
                        }else{
                            $('#simpan_data').show();
                            $('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 

        function import_simpan_data(){
            var form=document.getElementById('myimport_data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/kpi/import')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        data=msg.split('=');
                        
                        if(data[0]=='<p style'){
                            $('#modalloading').modal('hide');
                            $('#simpan_data').show();
                            $('#notifikasi_import').html(msg);
                            
                               
                        }else{
                            $('#modal-import').modal('hide');
                            $('#modalloading').modal('hide');
                            $("#tampilkan").load("{{url('kpi/view_data_user?unit='.$unit_id.'&periode='.$periode)}}");
                        }
                        
                        
                    }
                });

        } 

        function ubah_data(){
            var form=document.getElementById('myubah_data');
                var id=$('#id').val();
                $.ajax({
                    type: 'POST',
                    url: "{{url('/risiko/ubah_data')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(msg){
                        
                        if(msg=='ok'){
                            location.reload();
                        }else{
                            $('#notifikasiubah').html(msg);
                        }
                        
                        
                    }
                });

        } 
        function ubah_data_risiko(){
            var form=document.getElementById('myubah_data_risiko');
                var id=$('#id').val();
                $.ajax({
                    type: 'POST',
                    url: "{{url('/risiko/ubah_data_risiko')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(msg){
                        
                        if(msg=='ok'){
                            location.reload();
                        }else{
                            $('#notifikasiubah_risiko').html(msg);
                        }
                        
                        
                    }
                });

        } 


        function ubah_data_sts(){
            var form=document.getElementById('myubah_data_sts');
                var id=$('#id').val();
                $.ajax({
                    type: 'POST',
                    url: "{{url('/kpi/ubah_data_sts')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        
                        if(msg=='ok'){
                            $('#modalubah_sts').modal('hide');
                            $('#modalloading').modal('hide');
                            $("#tampilkan").load("{{url('kpi/view_data_user?unit='.$unit_id.'&periode='.$periode)}}");
                        }else{
                            $('#modalloading').modal('hide');
                            $('#notifikasiubahsts').html(msg);
                        }
                        
                        
                    }
                });

        } 

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    
@endpush