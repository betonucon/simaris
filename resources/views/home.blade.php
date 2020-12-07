@extends('layouts.app')
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
        background:#fff;
        padding:5px;
    }
</style>
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active">
                        <h3 class="widget-user-username">{{Auth::user()['name']}}</h3>
                        <h5 class="widget-user-desc">{{Auth::user()['email']}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{url(url_link().'/img/akun.png')}}" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-2 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Administrator<br><br></h5>
                                    <span class="description-text">{!!cek_role(admin())!!}</span>
                                </div>
                            </div>
                            <div class="col-sm-2 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Keyperson<br><br></h5>
                                    <span class="description-text">{!!cek_role(keyperson())!!}</span>
                                </div>
                            </div>
                            <div class="col-sm-2 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Verifikatur<br><br></h5>
                                    <span class="description-text">{!!cek_role(verifikatur())!!}</span>
                                </div>
                            </div>
                            <div class="col-sm-2 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Pimpinanunit<br><br></h5>
                                    <span class="description-text">{!!cek_role(pimpinanunit())!!}</span>
                                </div>
                            </div>
                            <div class="col-sm-2 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Managergcg<br><br></h5>
                                    <span class="description-text">{!!cek_role(managergcg())!!}</span>
                                </div>
                            </div>
                            <div class="col-sm-2 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">PimpinanSubdit<br><br></h5>
                                    <span class="description-text">{!!cek_role(pimpinansubdit())!!}</span>
                                </div>
                            </div>
                            
                        </div>
                    <!-- /.row -->
                    </div>
                </div>
            <!-- /.widget-user -->
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>

@endsection
