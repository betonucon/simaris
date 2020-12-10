@extends('layouts.app')
<style>
    th{
        font-size:12px;
        background:#b0e6e6;
        border:solid 1px #d1d1d6;
        padding:5px;
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
</style>
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="box-header" style="margin-bottom:1%;text-align:center">

                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Total KPI {{$periode}} </span>
                        <span class="info-box-number">{{total_kpi_unit($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">KPI Utama</span>
                        <span class="info-box-number">{{total_kpi_unit_utama($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">KPI Paling Utama</span>
                        <span class="info-box-number">{{total_kpi_unit_palingutama($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            <div class="box-header" style="margin-bottom:1%">
              <h3 class="box-title">
                <span class="btn btn-success btn-sm" onclick="tambah()"><i class="fa fa-plus"></i> Tambah Baru</span>
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

<div class="modal fade" id="modal-import" style="display: none;">
    <div class="modal-dialog" style="margin-top: 2%;">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Import Data KPI</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi_import"></div>
                <form method="post" id="myimport_data" action="{{url('/kpi/import')}}" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="form-group">
                        <label>Periode Aktif</label>
                        <input name="periode_id" class="form-control" type="text" value="{{periode_aktif()['name']}}">
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input name="file" class="form-control" type="file" >
                    </div>
                   
                </form>

                <div class="col-md-12">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="import_simpan_data()">Import Data</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog" style="margin-top: 2%;">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">KPI Baru</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="form-group">
                            <label>Kode KPI </label>
                            <input type="text"  name="kode"  value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama KPI</label>
                            <textarea name="name" class="form-control"  rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Periode Aktif</label>
                            <input  class="form-control" type="text" disabled value="{{periode_aktif()['name']}}">
                            <input name="periode_id" class="form-control" type="hidden" value="{{periode_aktif()['id']}}">
                        </div>
                        
                       
                    
                        <div class="form-group">
                            <label>Unit Kerja </label>
                            <input type="text"  disabled  value="{{cek_unit($unit_id)['nama']}}" value="" class="form-control">
                            <input type="hidden"  name="unit_id"  id="unit_id" value="{{$unit_id}}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Tahun </label>
                            <input type="number"  disabled value="{{periode_aktif()['tahun']}}" class="form-control">
                            <input type="hidden"  name="tahun"  value="{{periode_aktif()['tahun']}}" class="form-control">
                        </div>
                        
                     
                    
                </form>

                <div class="col-md-12">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="simpan_data()">Simpan Data</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="modalubah" style="display: none;">
    <div class="modal-dialog" style="margin-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ubah KPI</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah"></div>
                <form method="post" id="myubah_data" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="tampilkanubah"></div>
                        
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="ubah_data()">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalubah_sts" style="display: none;">
    <div class="modal-dialog" style="margin-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ubah Level </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubahsts"></div>
                <form method="post" id="myubah_data_sts" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="tampilkanubah_sts"></div>
                        
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="ubah_data_sts()">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalcetak" style="display: none;">
    <div class="modal-dialog" style="margin-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Cetak</h4>
            </div>
            <div id="notifcetak"></div>
            <div class="modal-body" id="printableArea" style="background:aqua;text-align:center">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="printDiv('printableArea')">Cetak</button>
                <button type="button" class="btn btn-default pull-left" onclick="kirim_email()">Kirim Email</button>
                
            </div>
        </div>
    </div>
</div>

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

        var periode=$('#periode').val();
       
       
        $(document).ready(function() {
            
            $.ajax({
               type: 'GET',
               url: "{{url('kpi/view_data_user?unit='.$unit_id)}}&periode="+periode,
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
               url: "{{url('kpi/view_data_user?unit='.$unit_id)}}&periode="+a,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                   $("#tampilkan").html(msg);
                  
               }
           });
            
        }

        function cari_unit(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('kpi/cari_unit')}}?name="+a,
               data: "id=id",
               success: function(msg){
                   var data=msg.split('/');
                   $("#nama_unit").val('['+data[1]+']'+data[0]);
                   $("#unit_id").val(data[1]);
                  
               }
           });
            
        }
        function cari_unit_ubah(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('kpi/cari_unit')}}?name="+a,
               data: "id=id",
               success: function(msg){
                   var data=msg.split('/');
                   $("#nama_unit2").val('['+data[1]+']'+data[0]);
                   $("#unit_id2").val(data[1]);
                  
               }
           });
            
        }
        function cek(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('kasir/cek')}}/"+a,
               data: "id=id",
               success: function(msg){
                    $('#modalloading').modal('hide');
                    $("#tampilkan").load("{{url('kasir/view_data_user?unit='.$unit_id.'&periode='.$periode)}}");
                  
               }
           });
            
        }
        function uncek(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('kasir/uncek')}}/"+a,
               data: "id=id",
               success: function(msg){
                    $('#modalloading').modal('hide');
                    $("#tampilkan").load("{{url('kasir/view_data_user?unit='.$unit_id.'&periode='.$periode)}}");
                  
               }
           });
            
        }
        function kirim_email()
        {
           var idnya=$('#idnya').val();
           $.ajax({
               type: 'GET',
               url: "{{url('kasir/kirim_email')}}/"+idnya,
               data: "id=id",
               beforeSend: function(){
                    $('#modalloading').modal({backdrop: 'static', keyboard: false});
               },
               success: function(msg){
                   $('#modalloading').modal('hide');
                   $("#notifcetak").html(msg);
                  
               }
           });
            
        }

        function hapus(a){
            if (confirm('Apakah yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('kpi/hapus')}}/"+a,
                    data: "id=id",
                    beforeSend: function(){
                                $('#modalloading').modal({backdrop: 'static', keyboard: false});
                        },
                    success: function(msg){
                            $('#modalloading').modal('hide');
                            $("#tampilkan").load("{{url('kpi/view_data_user?unit='.$unit_id.'&periode='.$periode)}}");
                        
                    }
                });
            }

        }
        
        function ubah(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('kpi/ubah')}}/"+a,
               data: "id=id",
               success: function(msg){
                   $("#tampilkanubah").html(msg);
                   $('#modalubah').modal({backdrop: 'static', keyboard: false});
                  
               }
           });
            
        }

        function cek_modal(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('kpi/ubah_sts')}}/"+a,
               data: "id=id",
               success: function(msg){
                   $("#tampilkanubah_sts").html(msg);
                   $('#modalubah_sts').modal({backdrop: 'static', keyboard: false});
                  
               }
           });
            
        }

        function cetak(a){
           
            $("#printableArea").load("{{url('kasir/cetak')}}/"+a);
            $('#modalcetak').modal({backdrop: 'static', keyboard: false});
            
        }

        function simpan_data(){
            var form=document.getElementById('mysimpan_data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/kpi/simpan')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        if(msg=='ok'){
                           location.reload();
                        }else{
                            $('#modalloading').modal('hide');
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
                    url: "{{url('/kpi/ubah_data')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        
                        if(msg=='ok'){
                            location.reload();
                        }else{
                            $('#modalloading').modal('hide');
                            $('#notifikasiubah').html(msg);
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