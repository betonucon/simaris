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
            
            <div class="box-header" style="margin-bottom:1%;text-align:center">

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Total KPI  </span>
                        <span class="info-box-number">{{total_kpi_unit($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Proses Keypersson</span>
                        <span class="info-box-number">{{total_kpi_unit_proses($unit_id,periode_aktif()['id'])}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Proses Verifikatur</span>
                        <span class="info-box-number">{{(total_kpi_unit_verifikatur($unit_id,periode_aktif()['id']))}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline" style="margin-top: 20%;"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Proses Pimpinan Unit</span>
                        <span class="info-box-number">{{(total_kpi_unit_pimpinan($unit_id,periode_aktif()['id']))}}<small> KPI</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            
            <div class="box-header" style="margin-bottom:1%">
                
              <h3 class="box-title">
                <!-- <span class="btn btn-success btn-sm" onclick="tambah()"><i class="fa fa-plus"></i> Tambah Baru</span> -->
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

<div class="modal fade" id="modalubahvalidasi" style="display: none;">
    <div class="modal-dialog" style="margin-top: 0%;">
        <div class="modal-content" style="display: flow-root;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Proses validasi Pimpinan</h4>
            </div>
            <div class="modal-body">
                <div id="notifikasiubah_datavalidasi"></div>
                <form method="post" id="myubah_datavalidasi" action="{{url('/risiko/ubah_validasi')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="risikobisnis_id_validasi"  name="risikobisnis_id">
                    <select name="sts" class="form-control" onchange="cek_validasi(this.value)">
                        <option value="">Pilih status validasi</option>
                        <option value="3">Setujui</option>
                        <option value="1">Kembalikan</option>
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

<div class="modal fade" id="modalulasan" style="display: none;">
    <div class="modal-dialog" style="margin-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ulasan PimpinanGCG </h4>
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
            $('#alasan').hide();
            $.ajax({
               type: 'GET',
               url: "{{url('risiko/view_data_pimpinanunit?unit='.$unit_id)}}&periode="+periode,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                    $('#modalloading').modal('hide');
                    data=msg.split('|');
                    $("#tampilkan").html(data[0]);
                    $("#namaunit").html(data[1]);
                    $("#labelnya").html(data[2]);
                    $("#labelnya2").html(data[3]);
                    $("#labelnya3").html((data[2]-data[3]));
                  
               }
           });
            

        });

        function cari(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/view_data_pimpinanunit?unit='.$unit_id)}}&periode="+a,
               data: "id=id",
               beforeSend: function(){
                    $("#tampilkan").html('<center><img src="{{url(url_link().'/img/loading.gif')}}" width="3%"> Proses Data.............</center>');
               },
               success: function(msg){
                   $("#tampilkan").html(msg);
                  
               }
           });
            
        }

        function validasi(a){
            $('#modalubahvalidasi').modal({backdrop: 'static', keyboard: false});
            $('#risikobisnis_id_validasi').val(a);
        }

        function cek_validasi(a){
           
           if(a==1){
                $('#alasan').show();
           }else{
                $('#alasan').hide();
           }
            
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

        

        function cetak(a){
           
            $("#printableArea").load("{{url('kasir/cetak')}}/"+a);
            $('#modalcetak').modal({backdrop: 'static', keyboard: false});
            
        }

        
        function ubah_datavalidasi(){
            var form=document.getElementById('myubah_datavalidasi');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/risiko/ubah_validasi')}}?role_id=2",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        data=msg.split('|');
                        if(data[0]=='ok'){
                            window.location.assign("{{url('risiko/pimpinanunit')}}?unit="+data[1]);
                               
                        }else{
                            $('#notifikasiubah_datavalidasi').html(msg);
                            $('#modalloading').modal('hide');
                            
                        }
                        
                        
                    }
                });

        } 
        function cek_alasan(a){
           
           $.ajax({
               type: 'GET',
               url: "{{url('risiko/ulasan')}}/"+a+"?role=3",
               data: "id=id",
               success: function(msg){
                   $('#modalulasan').modal({backdrop: 'static', keyboard: false});
                   $("#tampilkanulasan").html(msg);
                   
                  
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