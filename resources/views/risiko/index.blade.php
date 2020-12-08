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
    .form-group {
    
}
</style>
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="box-header" style="margin-bottom:0%;text-align:center">

                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="info-box" style="min-height:40px">
                        
                        <div class="info-box-content">
                        <span class="info-box-text">Total KPI  </span>
                        <span class="info-box-number">{{total_kpi_unit($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box" style="min-height:40px">
                        
                        <div class="info-box-content">
                        <span class="info-box-text">Sudah diproses</span>
                        <span class="info-box-number">{{total_kpi_unit_proses($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box" style="min-height:40px">
                        
                        <div class="info-box-content">
                        <span class="info-box-text">Belum diproses</span>
                        <span class="info-box-number">{{(total_kpi_unit($unit_id,periode_aktif()['id'])-total_kpi_unit_proses($unit_id,periode_aktif()['id']))}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            
            <div class="box-header" style="margin-bottom:0%">
                
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

<div class="modal fade" id="modalulasan" style="display: none;">
    <div class="modal-dialog" style="margin-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ulasan Verifikatur </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubahsts"></div>
                <form method="post" id="myubah_data_sts" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="tampilkanulasan"></div>
                        
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaldampak" style="display: none;z-index: 2000;">
    <div class="modal-dialog" style="margin-top: 1%;width:80%">
        <div class="modal-content">
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <th>No</th>
                        <th>DAMPAK</th>
                        @foreach(kategori() as $kategori)
                            <th style="text-transform:uppercase;padding:5px">{{$kategori['name']}}</th>
                        @endforeach
                        
                    </tr>
                    @foreach(dampak() as $da=>$dampak)
                        <tr>
                            <td style="padding:5px;vertical-align:top">{{$da+1}}</td>
                            <td style="padding:5px;vertical-align:top">{{$dampak['name']}}</td>
                            @foreach(kategori() as $kategori)
                                <td style="padding:5px;vertical-align:top;font-size:11px">
                                       @foreach(kriteria($dampak['id'],$kategori['id']) as $ket=>$kriteria) 
                                            @if($ket==1) <hr> @endif
                                            <a href="#" onclick="pilihdampak('{{$kriteria['name']}}','{{$kriteria['id']}}','{{$kategori['id']}}','{{$dampak['id']}}')">{{$kriteria['name']}}</a>
                                       @endforeach
                                </td>
                            @endforeach
                            
                        </tr>
                    @endforeach
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;width:90%">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Risiko Baru</h4>
            </div>
            <div class="modal-body" >
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Periode </label><br>
                            <input type="text" disabled  style="display:inline;width:78%" value="{{periode_aktif()['name']}}" class="form-control">
                            <input type="text"  style="display:inline;width:20%" name="tahun"  value="{{periode_aktif()['tahun']}}" class="form-control">
                            <input type="hidden"  name="periode_id"  value="{{periode_aktif()['id']}}" class="form-control">
                            <input type="hidden"  name="unit_id"  value="{{$unit_id}}" class="form-control">
                        </div>
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Kode KPI </label>
                            <select name="kpi_id"  id="kpi_id" class="form-control" placeholder="Search">
                                    <option value="">Pilih KPI</option>
                                    @foreach(get_kpi($unit_id,periode_aktif()['id']) as $get_kpi)
                                        <option value="{{$get_kpi['id']}}"  >[{{$get_kpi['tahun']}}] {{$get_kpi['name']}}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Risiko</label>
                            <textarea name="risiko" class="form-control" placeholde="Enter.................." rows="3"></textarea>
                        </div>
                        
                        
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Akibat</label>
                            <textarea name="akibat" class="form-control" placeholde="Enter.................." rows="3"></textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Klasifikasi </label>
                            <select name="klasifikasi_id"  id="klasifikasi_id" class="form-control" placeholder="Search">
                                    <option value="">Pilih Klasifikasi</option>
                                    @foreach(klasifikasi() as $klasifikasi)
                                        <option value="{{$klasifikasi['id']}}"  >[{{$klasifikasi['id']}}] {{$klasifikasi['name']}}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Peluang </label>
                            <select name="peluang_id"  id="klasifikasi_id" class="form-control" placeholder="Search">
                                    <option value="">Pilih Peluang</option>
                                    @foreach(peluang() as $peluang)
                                        <option value="{{$peluang['id']}}"  >[{{$peluang['name']}}] {{$peluang['kriteria']}}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Dampak </label><br>
                            <span class="btn btn-primary btn-sm" onclick="dampaknya()"><i class="fa fa-search"> Dampak</i></span>
                            <br><br><textarea disabled id="nama_kriteria" class="form-control" rows="3"></textarea>
                            <input type="hidden" name="kriteria_id" id="kriteria_id" class="form-control" >
                            <input type="hidden" name="kategori_id" id="kategori_id" class="form-control" >
                            <input type="hidden" name="dampak_id" id="dampak_id" class="form-control" >
                        </div>
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Indikator</label>
                            <textarea name="indikator" class="form-control" placeholde="Enter.................." rows="3"></textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label>Nilai Ambang</label>
                            <input type="text" name="nilai_ambang" class="form-control" >
                        </div>
                        
                       
                    </div>    
                    <div class="col-md-12">

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
    <div class="modal-dialog" style="margin-top: 0%;width:95%">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Sumber Risiko</h4>
            </div>
            <div class="modal-body" >
                <div style="width:100%;display: flow-root;">
                    <div id="notifikasiubah"></div>
                    <form method="post" id="myubah_data" enctype="multipart/form-data">
                        @csrf
                        
                        <div id="tampilkanubah"></div>
                        
                            
                        
                    </form>
                    <div class="col-sm-12" style="margin-top:2%">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" style="margin-left:1%" onclick="ubah_data()">Simpan Data</button>
                     </div>
                </div>
                <div id="tampilkanubah_data" style="width:100%;display: flow-root;"></div>
            </div>
            
            
        </div>
    </div>
</div>
<div class="modal fade" id="modalubah_detail" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;width:90%">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Sumber Risiko</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah_detail"></div>
                
                    
                    <div id="tampilkanubah_detail"></div>
                        
                    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalubahrisiko" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;width:90%">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ubah Risiko</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah_risiko"></div>
                <form method="post" id="myubah_data_risiko" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="tampilkanubahrisiko"></div>
                        
                    
                </form>
            </div>
            <div class="col-md-12">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="ubah_data_risiko()">Simpan Data</button>
                </div>
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
               url: "{{url('risiko/view_data?unit='.$unit_id)}}&periode="+periode,
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

        function cek_alasan(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/ulasan')}}/"+a+"?role=1",
               data: "id=id",
               success: function(msg){
                   $('#modalulasan').modal({backdrop: 'static', keyboard: false});
                   $("#tampilkanulasan").html(msg);
                   
                  
               }
           });
            
        }

        function pilihdampak(nama_kriteria,kriteria_id,kategori_id,dampak_id){
            $('#modaldampak').modal('hide');
            $('#nama_kriteria').val(nama_kriteria);
            $('#kriteria_id').val(kriteria_id);
            $('#kategori_id').val(kategori_id);
            $('#dampak_id').val(dampak_id);
            $('#nama_kriteriad').val(nama_kriteria);
            $('#kriteria_idd').val(kriteria_id);
            $('#kategori_idd').val(kategori_id);
            $('#dampak_idd').val(dampak_id);
        }

        function cari(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/view_data?unit='.$unit_id)}}&periode="+a,
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
        function cek_dampak(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/view_dampak')}}?dampak="+a,
               data: "id=id",
               success: function(msg){
                   $("#tampildampak").html(msg);
                  
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

        function sumber_detail(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/sumber_verifikatur')}}/"+a,
               data: "id=id",
               success: function(msg){
                   $("#tampilkanubah_detail").html(msg);
                   $('#modalubah_detail').modal({backdrop: 'static', keyboard: false});
                  
               }
           });
            
        }
        function dampaknya(){
           
            $('#modaldampak').modal({backdrop: 'static', keyboard: false});
              
            
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
        
        function sumber(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/sumber')}}/"+a,
               data: "id=id",
               success: function(msg){
                   data=msg.split('||');
                   $("#tampilkanubah").html(data[0]);
                   $("#tampilkanubah_data").html(data[1]);
                   $('#modalubah').modal({backdrop: 'static', keyboard: false});
                  
               }
           });
            
        }

        function ubah(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/ubah')}}/"+a,
               data: "id=id",
               success: function(msg){
                   $("#tampilkanubahrisiko").html(msg);
                   $("#notifikasiubah_risiko").html('');
                   $('#modalubahrisiko').modal({backdrop: 'static', keyboard: false});
                  
               }
           });
            
        }
        function selesai(a){
            if (confirm('Apakah yakin data ini sudah selesai?')) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('risiko/ubah_sts')}}/"+a,
                    data: "id=id",
                    success: function(msg){
                        location.reload();
                        
                    }
                });
            }
            
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
        function hapus_sumber(no,id){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/hapus_sumber')}}?no="+no+"&id="+id,
               data: "no="+no+"&id="+id,
               success: function(msg){
                        $.ajax({
                            type: 'GET',
                            url: "{{url('risiko/sumber')}}/"+msg,
                            data: "id=id",
                            success: function(det){
                                has=det.split('||');
                                $("#tampilkanubah").html(has[0]);
                                $("#tampilkanubah_data").html(has[1]);
                                $('#notifikasiubah').html('');
                                
                            }
                        });
                  
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
                        data=msg.split('||');
                        if(data[0]=='ok'){
                            $.ajax({
                                type: 'GET',
                                url: "{{url('risiko/sumber')}}/"+data[1],
                                data: "id=id",
                                success: function(det){
                                    has=det.split('||');
                                    $("#tampilkanubah").html(has[0]);
                                    $("#tampilkanubah_data").html(has[1]);
                                    $('#notifikasiubah').html('');
                                    
                                }
                            });
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