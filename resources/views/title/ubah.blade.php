@extends('layouts.app')

@section('content')
<style>
    #tambah{margin-left:2px;}
    #reload{margin-left:2px;}
    #cetak{margin-left:2px;}
</style>
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      {!!title($batal)!!}
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">&nbsp;</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body">
          
        <form method="post" id="mysimpan_data" enctype="multipart/form-data">
             @csrf
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama Halaman</label>
                    <input class="form-control item"   type="text" name="name" value="{{$data['name']}}">
                  </div>
                  <div class="form-group">
                    <label>Judul Halaman</label>
                    <input class="form-control item"   type="text" name="title" value="{{$data['title']}}">
                  </div>
                  
                  
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Keterangan Halaman</label>
                    <textarea class="form-control"   rows="3" name="isi">{{$data['isi']}}</textarea>               </div>
                  </div>
                  
              </div>
              
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <span class="btn btn-primary btn-sm" id="simpan"><i class="fa fa-save text-yellow"></i> Simpan</span>
            <span class="btn btn-success btn-sm" id="batal"><i class="fa fa-undo text-yellow"></i> Batal</span>
        </div>
      </div>
      

      
      
</section>

  <div class="modal fade" id="modalnotif" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align:center">
                <div id="notifikasi"></div>
            </div>
            
        </div>
    </div>
  </div>
  <div class="modal fade" id="modalloading" >
      <div class="modal-dialog">
          <div class="modal-content" >
              <div class="modal-header">
                  <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Wait </h4>
              </div>
              <div class="modal-body" style="text-align:center">
                  <img src="{{url('public/img/loading.gif')}}" style="width:30%"></img>
              </div>
              
          </div>
      </div>
  </div>
  
@endsection

@push('datatable')
    <script>
        $(document).ready(function(){
            $(":input").inputmask();



            $("#phone").inputmask({
              mask: '9999-9999',
              placeholder: ' ',
              showMaskOnHover: false,
              showMaskOnFocus: false,
              onBeforePaste: function (pastedValue, opts) {
              var processedValue = pastedValue;

              //do something with it

              return processedValue;
              }
            });
        });
        $(document).ready(function() {
            
            $('#batal').click(function(){
                window.location.assign("{{url($batal)}}");
            });

            $('#hapus_file').click(function(){
                
                $.ajax({
                    type: 'GET',
                    url: "{{url('/'.$batal.'/hapus_file/'.$data['id'])}}",
                    data: "id=1",
                    beforeSend: function(){
                        $('#modalloading').modal('show');
                    },
                    success: function(msg){
                        location.reload();
                    }
                });
            });

            $('#simpan').click(function(){
                
                var form=document.getElementById('mysimpan_data');
                
                $.ajax({
                    type: 'POST',
                    url: "{{url('/'.$batal.'/simpan_ubah/'.$data['id'])}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal('show');
                    },
                    success: function(msg){
                        
                        if(msg=='ok'){
                            window.location.assign("{{url($batal)}}")
                        }else{
                            $('#modalloading').modal('hide');
                            $('#modalnotif').modal('show');
                            $('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

            });
        });

        function hanyaAngka(evt) {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
    
            return false;
          return true;
        }
        

    </script>
@endpush
