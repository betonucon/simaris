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
            <div class="box-header" style="margin-bottom:1%">
              <h3 class="box-title">
              @if(admin()>0)
                <span class="btn btn-success btn-sm" onclick="tambah()"><i class="fa fa-plus"></i>{{admin()}} Tambah Baru</span>
                <span class="btn btn-primary btn-sm" onclick="importdata()"><i class="fa fa-clone"></i> Import</span>
                </h3>
              @endif
              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 600px;">
                  <select name="table_search" style="display:inline;width:40%" id="periode" onchange="cari_periode(this.value)" class="form-control pull-left" placeholder="Search">
                            <option value="">Pilih Priode</option>
                            @foreach(periode() as $peri)
                                <option value="{{$peri['id']}}" @if($periode==$peri['id']) selected @endif >[{{$peri['tahun']}}] {{$peri['name']}}</option>
                            @endforeach
                  </select>
                  <input type="text" name="table_search" id="name" style="display:inline;width:60%" onkeyup="cari(this.value)" class="form-control pull-right" placeholder="Search">

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
                        <label>Periode Kwartal</label>
                        <select  name="periode_id"    class="form-control">
                            <option value="">Pilih Priode</option>
                            @foreach(periode() as $peri)
                                <option value="{{$peri['id']}}">[{{$peri['tahun']}}] {{$peri['name']}}</option>
                            @endforeach
                        </select>
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
            <h4 class="modal-title">Trasaksi Baru</h4>
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
                            <label>Periode Kwartal</label>
                            <select  name="periode_id"   class="form-control">
                                <option value="">Pilih Priode</option>
                                @foreach(periode() as $peri)
                                    <option value="{{$peri['id']}}">[{{$peri['tahun']}}] {{$peri['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                       
                    
                        <div class="form-group">
                            <label>Unit Kerja </label>
                            <input type="text"  onkeyup="cari_unit(this.value)" placeholder="Cari kode unit atau nama unit" value="" class="form-control">
                            <input type="text"  disabled  id="nama_unit" value="" class="form-control">
                            <input type="hidden"  name="unit_id"  id="unit_id" value="" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Tahun </label>
                            <input type="number"  name="tahun"  value="" class="form-control">
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
               url: "{{url('kpi/view_data')}}?periode="+periode,
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
               url: "{{url('kpi/view_data')}}?name="+a+"&periode="+periode,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                   $("#tampilkan").html(msg);
                  
               }
           });
            
        }
        function cari_periode(a){
           var name=$('#name').val();
           $.ajax({
               type: 'GET',
               url: "{{url('kpi/view_data')}}?name="+name+"&periode="+a,
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
                    $("#tampilkan").load("{{url('kasir/view_data')}}");
                  
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
                    $("#tampilkan").load("{{url('kasir/view_data')}}");
                  
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
                            $("#tampilkan").load("{{url('kpi/view_data')}}?periode="+periode);
                        
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
                            $('#modal-default').modal('hide');
                            $('#modalloading').modal('hide');
                            $("#tampilkan").load("{{url('kpi/view_data')}}?periode="+periode);
                               
                        }else{
                            $('#modalloading').modal('hide');
                            $('#simpan_data').show();
                            $('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 

        function import_simpan_data(){
            if (confirm('Apakah yakin akan untuk mengupload kpi diperiode ini?')) {
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
                            $("#tampilkan").load("{{url('kpi/view_data')}}?periode="+periode);
                        }
                        
                        
                    }
                });
            }
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

        
    </script>
    
@endpush