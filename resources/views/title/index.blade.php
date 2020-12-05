@extends('layouts.app')

@section('content')
<style>
    #tambah{margin-left:2px;}
    #reload{margin-left:2px;}
    #proses{margin-left:2px;}
    #cetak{margin-left:2px;}
    #hapus{margin-left:2px;}
</style>
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            
            <!-- /.box-header -->
            <div class="margin">
                {!!title($link)!!}
                <div class="btn-group" style="width:100%;">
                    <button type="button" class="btn btn-xs btn-primary btn-flat" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-xs btn-default btn-flat" id="reload"><i class="fa fa-history"></i> Perbaharui</button>
                    <button type="button" class="btn btn-xs btn-danger btn-flat" id="hapus"><i class="fa fa-trash"></i> Hapus</button>
                    <button type="button" class="btn btn-xs btn-success btn-flat" id="cetak"><i class="fa fa-print"></i> Cetak</button>
                    
                </div>
            </div>
            
            <div class="box-body">
                <form method="post" id="mydata" enctype="multipart/form-data">
                    @csrf
                    <table id="tabeldata" class="table table-bordered table-striped">
                        
                    </table>
                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

    <div class="modal fade" id="modalloading" >
      <div class="modal-dialog">
          <div class="modal-content" style="margin-top: 30%;">
              <div class="modal-header">
                  <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Wait </h4>
              </div>
              <div class="modal-body" style="text-align:center">
                  <img src="{{url('public/img/loading.gif')}}" style="width:30%">
              </div>
              
          </div>
      </div>
    </div>
    <div class="modal fade" id="prosesdata" >
      <div class="modal-dialog">
          <div class="modal-content" style="margin-top: 30%;">
              <div class="modal-header">
                  <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Wait </h4>
              </div>
              <div class="modal-body" style="text-align:center">
                  <img src="{{url('public/img/loading.gif')}}" style="width:30%">
              </div>
              
          </div>
      </div>
    </div>
@endsection

@push('datatable')
    <script>
        
        $(document).ready(function() {
            
                
            var table = $('#tabeldata').DataTable({
                responsive: true,
                scrollY: "450px",
                scrollCollapse: true,
                ordering   : false,
                paging   : false,
                info   : false,
                oLanguage: {"sSearch": "<span class='btn btn-default btn sm'><i class='fa fa-search'></i></span>" },
                "ajax": {
                    "type": "GET",
                    "url": "{{url($link.'/api')}}",
                    "timeout": 120000,
                    "dataSrc": function (json) {
                        if(json != null){
                            return json
                        } else {
                            return "No Data";
                        }
                    }
                },
                "sAjaxDataProp": "",
                "width": "100%",
                "order": [[ 4, "asc" ]],
                "aoColumns": [
                    {
                        "mData": null,
                        "width":"5%",
                        "title": "No",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "mData": null,
                        "title": "<input type='checkbox'  id='pilihsemua'>",
                        "width":"3%",
                        "sortable": false,
                        "render": function (data, row, type, meta) {
                            let btn = '';

                            
                                    btn += '<input type="checkbox" id="pilih" name="id[]" value="'+data.id+'">';
                                

                            return btn;
                        }
                    },
                    
                    {
                        "mData": null,
                        "title": "Nama Halaman",
                        "render": function (data, row, type, meta) {
                            return data.name;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Judul",
                        "render": function (data, row, type, meta) {
                            return data.title;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Keterangan",
                        "render": function (data, row, type, meta) {
                            return data.isi;
                        }
                    },
                    
                    {
                        "mData": null,
                        "title": "",
                        "width":"5%",
                        "sortable": false,
                        "render": function (data, row, type, meta) {
                            let btn = '';

                            
                                    btn += '<span class="btn btn-success  btn-xs" onclick="ubah('+data.id+')"><i class="fa fa-pencil"></i></span>';
                                

                            return btn;
                        }
                    }
                ]
            });

            

            $('#proses').click(function(){
                $('#prosesdata').modal('show');
            });

            $('#reload').click(function(){
                location.reload();
            });

            $('#pilihsemua').click(function(){
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]').not(this).prop('checked', this.checked);
                // $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#hapus').click(function(){
                var form=document.getElementById('mydata');
                
                $.ajax({
                    type: 'POST',
                    url: "{{url('/'.$link.'/hapus')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function(msg){
                        // alert(msg);
                        location.reload();
                        
                    }
                });
            });
            $('#cetak').click(function(){
                var kat=$('#kat').val();
                window.open("{{url($link.'/cetak')}}/"+kat, '_blank');
                        
            });

            $('#tambah').click(function(){
                window.location.assign("{{url($link.'/tambah')}}");
            });
        });

        $('#cari').click(function(){
            var kat=$('#kat').val();
            window.location.assign("{{url($link)}}?kat="+kat);
        });
        function ubah(a){
            window.location.assign("{{url($link.'/ubah')}}/"+a);
        }
        
        
    </script>
@endpush
