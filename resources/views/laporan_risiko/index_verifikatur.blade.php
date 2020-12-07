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
            
            
            <div class="box-header" style="margin-bottom:1%">
              <h3 class="box-title" id="namaunit">
                    
                <span class="btn btn-success btn-sm" onclick="cetak()"><i class="fa fa-plus"></i> Export To Excel</span>
                {{cek_unit($unit_id)['nama']}}
                </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 600px;">
                  <select name="table_search" style="display:inline;width:37%" id="unit_id" onchange="cari_unit_id(this.value)" class="form-control pull-left" placeholder="Search">
                            <option value="" @if($unit_id=='') selected @endif>Pilih Unit</option>
                            @foreach(unit() as $unitnya)
                                <option value="{{$unitnya['objectabbr']}}" @if($unit_id==$unitnya['objectabbr']) selected @endif >{{$unitnya['nama']}}</option>
                            @endforeach
                  </select> &nbsp;
                  <select name="table_search" style="display:inline;width:59%" id="periode" onchange="cari(this.value)" class="form-control pull-right" placeholder="Search">
                        <option value="">Pilih Priode</option>
                        @foreach(periode() as $peri)
                            <option value="{{$peri['id']}}" @if($periode==$peri['id']) selected @endif >[{{$peri['tahun']}}] {{$peri['name']}}</option>
                        @endforeach
                  </select>
                  
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




<div class="modal fade" id="modalubahkaidah" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Tentukan Kaidah</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah_datakaidah"></div>
                <form method="post" id="myubah_datakaidah" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="risikobisnis_id" name="risikobisnis_id">
                    <select name="kaidah" class="form-control">
                        <option value="">Pilih Kaidah</option>
                        <option value="1">Sesuai Kaidah</option>
                        <option value="2">Tidak Sesuai Kaidah</option>
                    </select>
                        
                    
                </form>
            </div>
            <div class="col-md-12">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="ubah_datakaidah()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalubahvalidasi" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Proses validasi</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah_datavalidasi"></div>
                <form method="post" id="myubah_datavalidasi" action="{{url('/risiko/ubah_validasi')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="risikobisnis_id_validasi"  name="risikobisnis_id">
                    <select name="sts" class="form-control" onchange="cek_validasi(this.value)">
                        <option value="">Pilih status validasi</option>
                        <option value="2">Setujui</option>
                        <option value="0">Kembalikan</option>
                    </select><br>
                    <div id="alasan">
                        <label>Alasan</label>
                        <textarea name="keterangan"  class="form-control" rows="3"></textarea>  
                    </div>
                    
                </form>
            </div>
            <div class="col-md-12">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="ubah_datavalidasi()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalubahkelompok" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Tentukan kelompok</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah_datakelompok"></div>
                <form method="post" id="myubah_datakelompok" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="risikobisnis_id_kelompok" name="risikobisnis_id">
                    <select name="kelompok_id" class="form-control">
                        <option value="">Pilih kelompok</option>
                        @foreach(kelompok() as $kel)
                        <option value="{{$kel['id']}}">- {{$kel['name']}}</option>
                        @endforeach
                    </select>
                        
                    
                </form>
            </div>
            <div class="col-md-12">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="ubah_datakelompok()">Simpan Data</button>
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

<div class="modal fade" id="modalubah" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;width:90%">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Sumber Risiko</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah"></div>
                <form method="post" id="myubah_data" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="tampilkanubah"></div>
                        
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
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
        var unit=$('#unit_id').val();
       
       
        $(document).ready(function() {
            $('#alasan').hide();
            $.ajax({
               type: 'GET',
               url: "{{url('laporan_risiko/view_data_verifikatur')}}?unit="+unit+"&periode="+periode,
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
            var unit=$('#unit_id').val();
           $.ajax({
               type: 'GET',
               url: "{{url('laporan_risiko/view_data_verifikatur')}}?unit="+unit+"&periode="+a,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                   data=msg.split('|');
                   $("#tampilkan").html(data[0]);
                   $("#namaunit").html(data[1]);
                   $("#labelnya").html(data[2]);
                   
                  
               }
           });
            
        }

        function cari_unit_id(a){
            
           $.ajax({
               type: 'GET',
               url: "{{url('laporan_risiko/view_data_verifikatur')}}?unit="+a+"&periode="+periode,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                    data=msg.split('|');
                   $("#tampilkan").html(data[0]);
                   $("#namaunit").html(data[1]);
                   $("#labelnya").html(data[2]);
                   $("#labelnya2").html(data[3]);
                   $("#labelnya3").html((data[2]-data[3]));
                   
                  
               }
           });
            
        }
        function cetak(){
            var periode=$('#periode').val();
            var unit=$('#unit_id').val();
            window.location.assign("{{url('excel_laporan_risiko')}}?unit="+unit+"&periode="+periode);
            
        }
        
    </script>
    
@endpush