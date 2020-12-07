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
                <span class="btn btn-success btn-sm" onclick="tambah()"><i class="fa fa-plus"></i> Tambah Baru</span>
                </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 400px;">
                  <input type="text" name="table_search" onkeyup="cari(this.value)" class="form-control pull-right" placeholder="Search">

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
                        <label>Periode Kwartal</label>
                        <select  name="periode_id"   class="form-control">
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
            <h4 class="modal-title">Tambah Unit Kerja</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="form-group">
                            <label>Kode Unit </label>
                            <input type="text"  name="kode"  id="kode" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Objectabbr </label>
                            <input type="text"  name="objectabbr"  id="objectabbr" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama </label>
                            <input type="text"  name="nama"  id="nama" value="" class="form-control">
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
            <h4 class="modal-title">Ubah Unit Kerja</h4>
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

       
       
        $(document).ready(function() {
            $.ajax({
               type: 'GET',
               url: "{{url('unit/view_data')}}",
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                    $('#modalloading').modal('hide');
                    $("#tampilkan").html(msg);
                  
               }
           });
            
            $('#tampil_unit').hide();

        });

        function cari(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('unit/view_data')}}?name="+a,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                   $("#tampilkan").html(msg);
                  
               }
           });
            
        }

        function cari_nik(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('admin/cari_nik')}}?name="+a,
               data: "id=id",
               success: function(msg){
                   var data=msg.split('/');
                   $("#nama").val('['+data[1]+']'+data[0]);
                   $("#kode").val(data[1]);
                  
               }
           });
            
        }

        function cek_role(a){
           if(a==1 || a==3){
                $('#tampil_unit').show();
           }else{
                $('#tampil_unit').hide();
           }
            
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
        

        function hapus(a){
            if (confirm('Apakah yakin akan menghapus data ini?')) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('unit/hapus')}}/"+a,
                    data: "id=id",
                    beforeSend: function(){
                                $('#modalloading').modal({backdrop: 'static', keyboard: false});
                        },
                    success: function(msg){
                            $('#modalloading').modal('hide');
                            $("#tampilkan").load("{{url('unit/view_data')}}");
                        
                    }
                });
            }

        }
        
        function ubah(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('unit/ubah')}}/"+a,
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
                    url: "{{url('/unit/simpan')}}",
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
                            $("#tampilkan").load("{{url('user/view_data')}}");
                               
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
                            $("#tampilkan").load("{{url('kpi/view_data')}}");
                        }
                        
                        
                    }
                });

        } 

        function ubah_data(){
            var form=document.getElementById('myubah_data');
                var id=$('#id').val();
                $.ajax({
                    type: 'POST',
                    url: "{{url('/unit/ubah_data')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        
                        if(msg=='ok'){
                            $('#modalubah').modal('hide');
                            $('#modalloading').modal('hide');
                            $("#tampilkan").load("{{url('unit/view_data')}}");
                        }else{
                            $('#modalloading').modal('hide');
                            $('#notifikasiubah').html(msg);
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