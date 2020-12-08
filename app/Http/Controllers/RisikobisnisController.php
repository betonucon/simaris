<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Risikobisnis;
use App\Sumber;
use App\Alasan;
use App\Dampak;
use App\Kategori;
use App\Kpi;
use PDF;
use Session;
use App\Imports\KpiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RisikobisnisController extends Controller
{
    public function index(request $request){
       
        if(keyperson()>0){
            $halaman='Daftar Risiko Bisnis';
            $link='risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('risiko.index',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    
    public function index_pimpinanunit(request $request){
       
        if(pimpinanunit()>0){
            $halaman='Daftar Validasi Risiko Bisnis';
            $link='risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('risiko.index_pimpinanunit',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    public function index_verifikatur(request $request){
       
        if(verifikatur()>0){
            $halaman='Daftar Risiko Bisnis';
            $link='risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('risiko.index_verifikatur',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    public function index_pimpinangcg(request $request){
       
        if(pimpinangcg()>0){
            $halaman='Daftar Risiko Bisnis Validasi';
            $link='risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('risiko.index_pimpinangcg',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    public function hapus_sumber(request $request){
        $data=Sumber::where('id',$request->no)->delete();
        echo $request->id;
    }

    public function ubah_sts($id){
        $data       =Risikobisnis::find($id);
        $data->sts  =1;
        $data->save();

        $cekalasan      = Alasan::where('risikobisnis_id',$id)->count();
        if($cekalasan>0){
            $alasan      = Alasan::where('risikobisnis_id',$id)->update([
                'sts'=>1
            ]);
        }
        // echo $id;
        
       
    }

    public function ubah($id){
        
        $data=Risikobisnis::where('id',$id)->first();
        echo'
                <input type="hidden" name="id" value="'.$data['id'].'" class="form-control">
                <div class="col-sm-6">
                    
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Risiko</label>
                        <textarea name="risiko" class="form-control" placeholde="Enter.................." rows="3">'.$data['risiko'].'</textarea>
                    </div>
                    
                    
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Akibat  </label>
                        <textarea name="akibat" class="form-control" placeholde="Enter.................." rows="3">'.$data['akibat'].'</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Klasifikasi </label>
                        <select name="klasifikasi_id"  id="klasifikasi_id" class="form-control" placeholder="Search">
                                <option value="">Pilih Klasifikasi</option>';
                                foreach(klasifikasi() as $klasifikasi){
                                    if($data['klasifikasi_id']==$klasifikasi['id']){$cekdam='selected';}else{$cekdam='';}
                                    echo'<option value="'.$klasifikasi['id'].'" '.$cekdam.' >['.$klasifikasi['id'].'] '.$klasifikasi['name'].'</option>';
                                }
                            echo'
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Peluang </label>
                        <select name="peluang_id"  id="klasifikasi_id" class="form-control" placeholder="Search">
                                <option value="">Pilih Peluang</option>';
                                foreach(peluang() as $peluang){
                                    if($data['peluang_id']==$peluang['id']){$cekdam='selected';}else{$cekdam='';}
                                    echo'<option value="'.$peluang['id'].'" '.$cekdam.' >['.$peluang['name'].'] '.$peluang['kriteria'].'</option>';
                                }
                            echo'
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    
                    
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Dampak </label><br>
                        <span class="btn btn-primary btn-sm" onclick="dampaknya()"><i class="fa fa-search"> Dampak</i></span>
                        <br><br><textarea disabled id="nama_kriteriad" class="form-control" rows="3">'.cek_kriteria($data['kriteria_id'])['name'].'</textarea>
                        <input type="hidden" name="kriteria_id" id="kriteria_idd" class="form-control" value="'.$data['kriteria_id'].'" >
                        <input type="hidden" name="kategori_id" id="kategori_idd" class="form-control" value="'.$data['kategori_id'].'" >
                        <input type="hidden" name="dampak_id" id="dampak_idd" class="form-control" value="'.$data['dampak_id'].'" >
                    </div>
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Indikator</label>
                        <textarea name="indikator" class="form-control" placeholde="Enter.................." rows="3">'.$data['indikator'].'</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Nilai Ambang</label>
                        <input type="text" name="nilai_ambang" class="form-control" value="'.$data['nilai_ambang'].'">
                    </div>
                    
                    
                </div>    

        ';
        echo'
        <script>
            $(document).ready(function() {
                $("#tampildampak_2").load("'.url('risiko/view_dampak_edit?dampak='.$data['dampak_id'].'&ket='.$data['kriteria_id'].'&kat='.$data['kategori_id'].'').'");
            });
            function cek_dampak_2(a,kat){
                
                $.ajax({
                    type: `GET`,
                    url: "'.url('risiko/view_dampak_edit').'?dampak="+a+"&kat="+kat,
                    data: "id=id",
                    success: function(msg){
                        $("#tampildampak_2").html(msg);
                        
                    }
                });
                
            }
        </script>

        ';
            
       
        
    }
    public function sumber($id){
        
        $data=Risikobisnis::where('id',$id)->first();
        $sumber=Sumber::where('risikobisnis_id',$id)->get();
        echo'
        <style>
            th{text-align:center;padding:3px;}
            td{padding:4px;vertical-align:top;}
            .form-control{font-size:12px;padding-left:5px;height: 27px;}
        </style>
            <input type="hidden" name="id" value="'.$data['id'].'" class="form-control">
            <div class="col-sm-6">
                <div class="form-group" style="margin-bottom: 0px;">
                    <label>Sumber</label>
                    <textarea name="sumber" class="form-control" placeholde="Enter.................." rows="2"></textarea>
                </div>
                <div class="form-group" style="margin-bottom: 0px;">
                    <label>Mitigasi</label>
                    <textarea name="mitigasi" class="form-control" placeholde="Enter.................." rows="2"></textarea>
                </div>
                <div class="col-sm-6" style="margin:0px;padding: 0px;">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Biaya</label>
                        <input type="text" name="biaya" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6" style="margin:0px;padding-left: 2px;">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>File</label>
                        <input type="file" name="file" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group" style="margin-bottom: 0px;">
                    <label>PIC</label>
                    <textarea name="pic" class="form-control" placeholde="Enter.................." rows="2"></textarea>
                </div>
                <div class="form-group" style="margin-bottom: 0px;">
                    <label>Status</label>
                    <textarea name="status" class="form-control" placeholde="Enter.................." rows="2"></textarea>
                </div>
                <div class="col-sm-6" style="margin:0px;padding: 0px;">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>Start_date</label>
                        <input type="text" name="start_date" id="datetanggal1" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6" style="margin:0px;padding-left: 2px;">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label>End_date</label>
                        <input type="text" name="end_date" id="datetanggal2" class="form-control" >
                    </div>
                </div>
                
                
            </div> ||
            <div class="col-sm-12" style="margin-top:2%">
                <table width="100%" >
                    <tr>
                        <th>Sumber</th>
                        <th  width="20%">Mitigasi</th>
                        <th width="10%">Biaya</th>
                        <th width="8%">file</th>
                        <th width="10%">startdate</th>
                        <th width="10%">enddate</th>
                        <th width="10%">PIC</th>
                        <th width="8%">Status</th>
                        <th width="4%"></th>
                    </tr>';

                    foreach($sumber as $sum){
                        echo'
                        <tr>
                            <td>'.$sum['sumber'].'</td>
                            <td>'.$sum['mitigasi'].'</td>
                            <td>'.$sum['biaya'].'</td>
                            <td><a href="'.url('_file/'.$sum['file']).'" target="_blank">'.$sum['file'].'</a></td>
                            <td>'.$sum['start_date'].'</td>
                            <td>'.$sum['end_date'].'</td>
                            <td>'.$sum['pic'].'</td>
                            <td>'.$sum['status'].'</td>
                            <td><span class="btn btn-danger btn-sm" onclick="hapus_sumber('.$sum['id'].','.$sum['risikobisnis_id'].')"><i class="fa fa-remove"></i></span></td>
                        </tr>';
                    }
                    echo'
                </table>
            </div>
        ';

        
            echo'
                <script>
                    $(`#datetanggal1`).datepicker({
                        format:"yyyy-mm-dd",
                        autoclose: true
                    })
                    $(`#datetanggal2`).datepicker({
                        format:"yyyy-mm-dd",
                        autoclose: true
                    })
                </script>

            ';
       
        
    }

    public function sumber_verifikatur($id){
        
        $data=Risikobisnis::where('id',$id)->first();
        $ceksumber=Sumber::where('risikobisnis_id',$id)->count();
        echo'
        <style>
            th{text-align:center;}
            td{padding:4px;vertical-align:top;}

        </style>
        <input type="hidden" name="id" value="'.$data['id'].'" class="form-control">
            <table width="100%" border="1">
                <tr>
                    <th >Sumber risiko</th>
                    <th width="16%">Mitigasi</th>
                    <th width="16%">Biaya</th>
                    <th width="16%">Waktu</th>
                    <th width="16%">PIC</th>
                    <th width="16%">Status</th>
                </tr>
        ';

        for($x=1;$x<=$ceksumber;$x++){
            if($x%2==0){$warna='#f5f5f5';}else{$warna='#fff';}

            echo'
            <tr bgcolor="'.$warna.'">
                <td>'.cek_sumber($data['id'],$x)['sumber'].'</td>
                <td>'.cek_sumber($data['id'],$x)['mitigasi'].'</td>
                <td>'.cek_sumber($data['id'],$x)['biaya'].'  </td>
                <td>
                    <label>Startdate</label><br>
                    '.cek_sumber($data['id'],$x)['start_date'].'<br>
                    <label>Enddate</label></br>
                    '.cek_sumber($data['id'],$x)['end_date'].'

                </td>
                <td>'.cek_sumber($data['id'],$x)['pic'].'</td>
                <td>'.cek_sumber($data['id'],$x)['status'].'</td>
               
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            ';
            echo'
                <script>
                    $(`#datetanggal1'.$x.'`).datepicker({
                        format:"yyyy-mm-dd",
                        autoclose: true
                    })
                    $(`#datetanggal2'.$x.'`).datepicker({
                        format:"yyyy-mm-dd",
                        autoclose: true
                    })
                </script>

            ';
        }
            
        
            
       
        
    }


    public function view_dampak_lama(request $request){
        $data=Dampak::where('id',$request->dampak)->orderBy('level','Asc')->first();
        $kat=Kategori::orderBy('id','Asc')->get();
        echo'
            <style>
                th{background:aqua;padding:3px;}
                td{background:#fff;padding:3px;font-size:10px;vertical-align:top;}
            </style>
            <table border="1">
                <tr>
                    <th width="5%">No</th>';
                    foreach($kat as $ko){
                        echo'
                            <th>'.$ko['name'].'</th>
                        ';
                    }
            echo'</tr>';       
        
            echo'
                <tr>
                    <td>'.$data['id'].'</td>';
                    foreach($kat as $ka){
                        echo'
                            <td>';
                                foreach(get_kriteria($data['id'],$ka['id'],$data['level']) as $x=>$get){
                                    if($x==0){
                                        echo'';
                                    }else{
                                        echo'<hr>';
                                    }
                                    echo ($x+1).'.'.$get['name'];
                                    
                                        
                                    
                                }
                            echo'
                            </td>
                        ';
                    }

            echo'
                </tr>
            </table>
            ';
       
    }

    public function view_dampak(request $request){
        $data=Dampak::where('id',$request->dampak)->orderBy('level','Asc')->first();
        $kat=Kategori::orderBy('id','Asc')->get();
            echo'
                <style>
                    th{background:aqua;padding:3px;}
                    td{background:#e8f9f9;padding:3px;font-size:12px;vertical-align:top;}
                </style>
                <table>
                       <tr>
                            <th>No</th>
                            <th>Pilih</th>
                            <th>Keterangan</th>
                       </tr>';
                    foreach($kat as $no=>$ka){
                       
                                foreach(get_kriteria($data['id'],$ka['id'],$data['level']) as $x=>$get){
                                    echo'<tr>
                                            <td width="10%" align="center"><b>'.($x+$no+1).'</b></td>
                                            <td width="10%" align="center"><input type="radio" name="kriteria_id" value="'.$get['id'].'/'.$ka['id'].'"></td>
                                            <td><b>['.$ka['name'].']</b> '.$get['name'].'</td>
                                         </tr>';
                                }
                           
                    }
            echo'</table>';

           
    }
    public function view_dampak_edit(request $request){
        
        $data=Dampak::where('id',$request->dampak)->orderBy('level','Asc')->first();
        $kat=Kategori::orderBy('id','Asc')->get();
            echo'
                <style>
                    th{background:aqua;padding:3px;}
                    td{background:#e8f9f9;padding:3px;font-size:12px;vertical-align:top;}
                </style>
                <table>
                       <tr>
                            <th>No</th>
                            <th>Pilih</th>
                            <th>Keterangan</th>
                       </tr>';
                    foreach($kat as $no=>$ka){
                       
                                foreach(get_kriteria($data['id'],$ka['id'],$data['level']) as $x=>$get){
                                    if($request->ket.'/'.$request->kat==$get['id'].'/'.$ka['id']){$ceked='checked';}else{$ceked='';}
                                    echo'<tr>
                                            <td width="10%" align="center"><b>'.($x+$no+1).'</b></td>
                                            <td width="10%" align="center"><input type="radio" name="kriteria_id" '.$ceked.' value="'.$get['id'].'/'.$ka['id'].'"></td>
                                            <td><b>['.$ka['name'].']</b> '.$get['name'].'</td>
                                         </tr>';
                                }
                           
                    }
            echo'</table>';

           
    }

    public function view_data(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No</th>
                    <th width="5%">Det</th>
                    <th>KPI</th>
                    <th width="11%">Risiko</th>
                    <th width="11%">Akibat</th>
                    <th width="6%">Kaidah</th>
                    <th width="11%">Peluang</th>
                    <th width="11%">Dampak</th>
                    <th width="7%">Tingkat Risiko</th>
                    <th width="8%">Indikator</th>
                    <th width="8%">Nilai Ambang</th>
                    <th width="4%"></th>
                </tr>';
                if($cek>0){
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                }else{
                    // $data=Risikobisnis::with(['unit'])->orderBy('id','Desc')->get();
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('unit_id',$request->unit)->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    if(($no+1)%2==0){$warna='#f5f5f5';}else{$warna='#fff';}
                    if(cek_sumber_risiko($o['id'])>0){
                        $btn='success'; $title='Ubah Sumber';
                    }else{
                        $btn='primary'; $title='Input Sumber';
                    }
                    echo'    
                        <tr bgcolor="'.$warna.'">
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">';
                            if($o['sts']==0){
                                echo'<span class="btn btn-'.$btn.' btn-sm" '.$title.' onclick="sumber('.$o['id'].')"><i class="fa fa-reorder"></i></span>';
                                if(jum_alasan($o['id'],1)>0){
                                    echo'<br><br><span class="btn btn-warning btn-sm" onclick="cek_alasan('.$o['id'].')" title="Alasan"><i class="fa fa-comment"></i></span>';
                                }
                            }else{
                                echo'<span class="btn btn-success btn-sm" title="Sumber Risiko" onclick="sumber_detail('.$o['id'].')"><i class="fa fa-reorder"></i></span>';
                            }
                            
                            echo'
                            </td>
                            <td class="ttd">'.$o->kpi['name'].'</td>
                            <td class="ttd">'.$o['risiko'].'</td>
                            <td class="ttd">'.$o['akibat'].'</td>
                            <td class="ttd">'.cek_kaidah($o['kaidah']).'</td>
                            <td class="ttd">'.$o->peluang['kriteria'].'</td>
                            
                            <td class="ttd">'.$o->kriteria['name'].'</td>
                            <td class="ttd"><span class="label label-'.matrik($o['peluang_id'],$o['dampak_id'])['warna'].'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</span></td>
                            <td class="ttd">'.$o['indikator'].'</td>
                            <td class="ttd">'.$o['nilai_ambang'].' </td>
                            <td class="ttd">';
                            if($o['sts']==0){
                                echo'
                                <span class="btn btn-success btn-sm" onclick="ubah('.$o['id'].')"><i class="fa fa-pencil"></i></span><br><br>
                                <span class="btn btn-danger btn-sm" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span><br><br>
                                <span class="btn btn-warning btn-sm" onclick="selesai('.$o['id'].')"><i class="fa fa-check"></i></span>';
                                
                            }
                            else{
                                echo'
                                <span class="btn btn-default btn-sm" ><i class="fa fa-check"></i></span>';
                            }
                            echo'
                            </td>
                            
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function ulasan(request $request,$id){
        $data=Alasan::where('risikobisnis_id',$id)->where('role_id',$request->role)->where('sts',0)->get();
        foreach($data as $o){
            echo '
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                '.$o['keterangan'].'
              </div>';
        }
        
        
    }
    public function view_data_verifikatur(request $request){
        $cek=strlen($request->unit);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No </th>
                    <th width="5%">Det</th>
                    <th>KPI</th>
                    <th width="11%">Risiko</th>
                    <th width="11%">Akibat</th>
                    <th width="6%">Kaidah</th>
                    <th width="11%">Kelompok</th>
                    <th width="11%">Peluang</th>
                    <th width="11%">Dampak</th>
                    <th width="7%">Tingkat Risiko</th>
                    <th width="8%">Indikator</th>
                    <th width="8%">Nilai Ambang</th>
                    <th width="8%"></th>
                </tr>';
                if($cek>0){
                    
                    $unit=cek_unit($request->unit)['nama'];
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->whereIn('sts',[1,2,3,4])->where('periode_id',$request->periode)->where('unit_id',$request->unit)->orderBy('id','Desc')->get();
                }else{
                    $unit='All Unit Kerja';
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->whereIn('sts',[1,2,3,4])->where('periode_id',$request->periode)->orderBy('id','Desc')->paginate(100);
                }
                // dd($data);
                foreach($data as $no=>$o){
                    if(($no+1)%2==0){$warna='#f5f5f5';}else{$warna='#fff';}
                    if(cek_sumber_risiko($o['id'])>0){
                        $btn='<span class="btn btn-success btn-sm" title="Sumber Risiko" onclick="sumber('.$o['id'].')"><i class="fa fa-reorder"></i></span>';
                    }else{
                        $btn='';
                    }
                    echo'    
                        <tr bgcolor="'.$warna.'">
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">
                                '.$btn.'';
                                if(jum_alasan($o['id'],2)>0){
                                    echo'<br><br><span class="btn btn-warning btn-xs" onclick="cek_alasan('.$o['id'].')"><i class="fa fa-comment"></i></span>';
                                }
                            echo'
                            </td>
                            <td class="ttd">'.$o->kpi['name'].'</td>
                            <td class="ttd">'.$o['risiko'].'</td>
                            <td class="ttd">'.$o['akibat'].'</td>';
                            if($o['sts']==1){
                                echo'<td class="ttd">'.cek_kaidah_verifikatur($o['kaidah'],$o['id']).'</td>';
                            }else{
                                echo'<td class="ttd">'.cek_kaidah($o['kaidah']).'</td>';
                            }
                            echo'
                            <td class="ttd">'.$o->kelompok['name'].'</td>
                            <td class="ttd">'.$o->peluang['kriteria'].'</td>
                            
                           
                            <td class="ttd">'.$o->kriteria['name'].'</td>
                            <td class="ttd"><span class="label label-'.matrik($o['peluang_id'],$o['dampak_id'])['warna'].'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</span></td>
                            <td class="ttd">'.$o['indikator'].'</td>
                            <td class="ttd">'.$o['nilai_ambang'].'</td>
                            <td class="ttd">';
                            if($o['sts']==1){
                                echo'
                                <span class="btn btn-warning btn-xs" onclick="cek_kelompok('.$o['id'].')"><i class="fa fa-gear"></i> Kelompok</span><br><br>
                                <span class="btn btn-success btn-xs" onclick="validasi('.$o['id'].')"><i class="fa fa-pencil"></i> Validasi</span><br><br>';
                                
                            }else{
                                echo'<span class="btn btn-default btn-xs" ><i class="fa fa-check"></i> selesai</span>';
                            }
                                
                            echo'
                            </td>
                            
                         </tr>';
                }
         echo'
            </table>|'.$unit.'|'.total_risiko($request->unit,$request->periode).'|'.total_risiko_validasi($request->unit,$request->periode).'
        ';
    }

    public function view_data_pimpinangcg(request $request){
        $cek=strlen($request->unit);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No </th>
                    <th width="5%">Det</th>
                    <th>KPI</th>
                    <th width="11%">Risiko</th>
                    <th width="11%">Akibat</th>
                    <th width="6%">Kaidah</th>
                    <th width="11%">Kelompok</th>
                    <th width="11%">Peluang</th>
                    <th width="11%">Dampak</th>
                    <th width="7%">warna</th>
                    <th width="8%">Indikator</th>
                    <th width="8%">Nilai Ambang</th>
                    <th width="8%"></th>
                </tr>';
                if($cek>0){
                    
                    $unit=cek_unit($request->unit)['nama'];
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->whereIn('sts',[3,4])->where('periode_id',$request->periode)->where('unit_id',$request->unit)->orderBy('id','Desc')->get();
                }else{
                    $unit='All Unit Kerja';
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->whereIn('sts',[3,4])->where('periode_id',$request->periode)->orderBy('id','Desc')->paginate(100);
                }
                // dd($data);
                foreach($data as $no=>$o){
                    if(($no+1)%2==0){$warna='#f5f5f5';}else{$warna='#fff';}
                    if(cek_sumber_risiko($o['id'])>0){
                        $btn='<span class="btn btn-success btn-sm" title="Sumber Risiko" onclick="sumber('.$o['id'].')"><i class="fa fa-reorder"></i></span>';
                    }else{
                        $btn='';
                    }
                    echo'    
                        <tr bgcolor="'.$warna.'">
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">
                                '.$btn.'';
                                if(jum_alasan($o['id'],2)>0){
                                    echo'<br><br><span class="btn btn-warning btn-xs" onclick="cek_alasan('.$o['id'].')"><i class="fa fa-comment"></i></span>';
                                }
                            echo'
                            </td>
                            <td class="ttd">'.$o->kpi['name'].'</td>
                            <td class="ttd">'.$o['risiko'].'</td>
                            <td class="ttd">'.$o['akibat'].'</td>
                            <td class="ttd">'.cek_kaidah($o['kaidah']).'</td>
                            <td class="ttd">'.$o->kelompok['name'].'</td>
                            <td class="ttd">'.$o->peluang['kriteria'].'</td>
                            <td class="ttd">'.$o->kriteria['name'].'</td>
                            <td class="ttd"><span class="label label-'.matrik($o['peluang_id'],$o['dampak_id'])['warna'].'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</span></td>
                            <td class="ttd">'.$o['indikator'].'</td>
                            <td class="ttd">'.$o['nilai_ambang'].'</td>
                            <td class="ttd">';
                            if($o['sts']==3){
                                echo'
                                <span class="btn btn-success btn-xs" onclick="validasi('.$o['id'].')"><i class="fa fa-pencil"></i> Validasi</span><br><br>';
                                
                            }else{
                                echo'<span class="btn btn-default btn-xs" ><i class="fa fa-check"></i> selesai</span>';
                            }
                                
                            echo'
                            </td>
                            
                         </tr>';
                }
         echo'
            </table>|'.$unit.'|'.total_risiko($request->unit,$request->periode).'|'.total_risiko_validasi($request->unit,$request->periode).'
        ';
    }

    public function view_data_pimpinanunit(request $request){
        $cek=strlen($request->unit);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No </th>
                    <th width="5%">Det</th>
                    <th>KPI</th>
                    <th width="11%">Risiko</th>
                    <th width="11%">Akibat</th>
                    <th width="6%">Kaidah</th>
                    <th width="11%">Kelompok</th>
                    <th width="11%">Peluang</th>
                    <th width="11%">Dampak</th>
                    <th width="7%">warna</th>
                    <th width="8%">Indikator</th>
                    <th width="8%">Nilai Ambang</th>
                    <th width="8%"></th>
                </tr>';
                if($cek>0){
                    
                    $unit=cek_unit($request->unit)['nama'];
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->whereIn('sts',[2,3,4])->where('periode_id',$request->periode)->where('unit_id',$request->unit)->orderBy('id','Desc')->get();
                }else{
                    $unit='All Unit Kerja';
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->whereIn('sts',[2,3,4])->where('periode_id',$request->periode)->where('unit_id',$request->unit)->orderBy('id','Desc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    if(($no+1)%2==0){$warna='#f5f5f5';}else{$warna='#fff';}
                    if(cek_sumber_risiko($o['id'])>0){
                        $btn='<span class="btn btn-success btn-sm" title="Sumber Risiko" onclick="sumber_detail('.$o['id'].')"><i class="fa fa-reorder"></i></span>';
                    }else{
                        $btn='';
                    }
                    echo'    
                        <tr bgcolor="'.$warna.'">
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">
                                '.$btn.'';
                                if(jum_alasan($o['id'],3)>0){
                                    echo'<br><br><span class="btn btn-warning btn-xs" onclick="cek_alasan('.$o['id'].')"><i class="fa fa-comment"></i></span>';
                                }
                            echo'
                            </td>
                            <td class="ttd">'.$o->kpi['name'].'</td>
                            <td class="ttd">'.$o['risiko'].'</td>
                            <td class="ttd">'.$o['akibat'].'</td>
                            <td class="ttd">'.cek_kaidah($o['kaidah']).'</td>
                            <td class="ttd">'.$o->kelompok['name'].'</td>
                            <td class="ttd">'.$o->peluang['kriteria'].'</td>
                            <td class="ttd">'.$o->kriteria['name'].'</td>
                            <td class="ttd"><span class="label label-'.matrik($o['peluang_id'],$o['dampak_id'])['warna'].'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</span></td>
                            <td class="ttd">'.$o['indikator'].'</td>
                            <td class="ttd">'.$o['nilai_ambang'].'</td>
                            <td class="ttd">';
                            if($o['sts']==2){
                                echo'
                                <span class="btn btn-success btn-xs" onclick="validasi('.$o['id'].')"><i class="fa fa-pencil"></i> Validasi</span>';
                            }else{
                                echo'<span class="btn btn-default btn-xs" ><i class="fa fa-check"></i> selesai</span>';
                            }
                                
                            echo'
                            </td>
                            
                         </tr>';
                }
         echo'
            </table>|'.$unit.'|'.total_risiko($request->unit,$request->periode).'|'.total_risiko_validasi($request->unit,$request->periode).'
        ';
    }


    public function simpan(request $request){
        if (trim($request->periode_id) == '') {$error[] = '-Pilih Periode terlebih dahulu';}
        if (trim($request->risiko) == '') {$error[] = '- Isi Risiko terlebih dahulu';}
        if (trim($request->kpi_id) == '') {$error[] = '- Pilih KPI terlebih dahulu';}
        if (trim($request->akibat) == '') {$error[] = '- Isi Akibat terlebih dahulu';}
        if (trim($request->peluang_id) == '') {$error[] = '- Pilih Peluang terlebih dahulu';}
        if (trim($request->klasifikasi_id) == '') {$error[] = '- Pilih klasifikasi terlebih dahulu';}
        if (trim($request->dampak_id) == '') {$error[] = '- Pilih Dampak terlebih dahulu';}
        if (trim($request->kriteria_id) == '') {$error[] = '- Pilih Kriteria terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            $data               =   new Risikobisnis;
            $data->risiko       =   $request->risiko;
            $data->unit_id      =   $request->unit_id;
            $data->kpi_id       =   $request->kpi_id;
            $data->periode_id   =   $request->periode_id;
            $data->tahun        =   $request->tahun;
            $data->akibat       =   $request->akibat;
            $data->peluang_id   =   $request->peluang_id;
            $data->indikator   =   $request->indikator;
            $data->nilai_ambang   =   $request->nilai_ambang;
            $data->kriteria_id   =   $request->kriteria_id;
            $data->tanggal       =   date('Y-m-d');
            $data->kategori_id   =   $request->kategori_id;
            $data->sts          =   0;
            $data->kaidah          =   0;
            $data->klasifikasi_id    =   $request->klasifikasi_id;
            $data->dampak_id    =   $request->dampak_id;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            if($data){
                $kpii               =  Kpi::find($request->kpi_id);
                $kpii->sts          = 1;
                $kpii->save();

                

                echo'ok';
            }

        }
    }
    
    public function ubah_kaidah(request $request){
        error_reporting(0);
        if (trim($request->kaidah) == '') {$error[] = '-Pilih Kaidah terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Risikobisnis::where('id',$request->risikobisnis_id)->first();
            $data               =   Risikobisnis::find($request->risikobisnis_id);
            $data->kaidah       =   $request->kaidah;
            $data->save();

            if($data){
                echo'ok|'.$cek['unit_id'];
            }

        }
        
    }

    public function ubah_kelompok(request $request){
        error_reporting(0);
        if (trim($request->kelompok_id) == '') {$error[] = '-Pilih Kelompok terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Risikobisnis::where('id',$request->risikobisnis_id)->first();
            $data               =   Risikobisnis::find($request->risikobisnis_id);
            $data->kelompok_id       =   $request->kelompok_id;
            $data->save();

            if($data){
                echo'ok|'.$cek['unit_id'];
            }

        }
        
    }

    public function ubah_validasi(request $request){
        error_reporting(0);
        if (trim($request->sts) == '') {$error[] = '-Pilih Status terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Risikobisnis::where('id',$request->risikobisnis_id)->first();
            if($request->sts==0 && $request->role_id==1){
                if($request->keterangan==''){
                    echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />- Masukan Alasan kenapa dikembalikan</p>';
                }else{
                    $data               =   Risikobisnis::find($request->risikobisnis_id);
                    $data->sts          =   $request->sts;
                    $data->save();

                    if($data){
                        $alasan     = new Alasan;
                        $alasan->risikobisnis_id = $request->risikobisnis_id;
                        $alasan->periode_id = $cek['periode_id'];
                        $alasan->unit_id = $cek['unit_id'];
                        $alasan->keterangan = $request->keterangan;
                        $alasan->sts = 0;
                        $alasan->role_id = $request->role_id;
                        $alasan->save();

                        echo'ok|'.$cek['unit_id'];
                    }
                }
                    
            }

            if($request->sts==1 && $request->role_id==2 ){
                if($request->keterangan==''){
                    echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />- Masukan Alasan kenapa dikembalikan</p>';
                }else{
                    $data               =   Risikobisnis::find($request->risikobisnis_id);
                    $data->sts          =   $request->sts;
                    $data->save();

                    if($data){
                        $alasan     = new Alasan;
                        $alasan->risikobisnis_id = $request->risikobisnis_id;
                        $alasan->periode_id = $cek['periode_id'];
                        $alasan->unit_id = $cek['unit_id'];
                        $alasan->keterangan = $request->keterangan;
                        $alasan->sts = 0;
                        $alasan->role_id = $request->role_id;
                        $alasan->save();

                        echo'ok|'.$cek['unit_id'];
                    }
                }
                    
            }

            if($request->sts==2 && $request->role_id==3 ){
                if($request->keterangan==''){
                    echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />- Masukan Alasan kenapa dikembalikan</p>';
                }else{
                    $data               =   Risikobisnis::find($request->risikobisnis_id);
                    $data->sts          =   $request->sts;
                    $data->save();

                    if($data){
                        $alasan     = new Alasan;
                        $alasan->risikobisnis_id = $request->risikobisnis_id;
                        $alasan->periode_id = $cek['periode_id'];
                        $alasan->unit_id = $cek['unit_id'];
                        $alasan->keterangan = $request->keterangan;
                        $alasan->sts = 0;
                        $alasan->role_id = $request->role_id;
                        $alasan->save();

                        echo'ok|'.$cek['unit_id'];
                    }
                }
                    
            }
            
            
            else{
                $data               =   Risikobisnis::find($request->risikobisnis_id);
                $data->sts          =   $request->sts;
                $data->save();

                if($data){
                    echo'ok|'.$cek['unit_id'];
                }
            }
               

        }
        
    }


    public function ubah_data_risiko(request $request){
        error_reporting(0);
        
        if (trim($request->risiko) == '') {$error[] = '- Isi Risiko terlebih dahulu';}
        if (trim($request->akibat) == '') {$error[] = '- Isi Akibat terlebih dahulu';}
        if (trim($request->peluang_id) == '') {$error[] = '- Pilih Peluang terlebih dahulu';}
        if (trim($request->klasifikasi_id) == '') {$error[] = '- Pilih klasifikasi terlebih dahulu';}
        if (trim($request->dampak_id) == '') {$error[] = '- Pilih Dampak terlebih dahulu';}
        if (trim($request->kriteria_id) == '') {$error[] = '- Pilih Kriteria terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            $data               =   Risikobisnis::find($request->id);
            $data->risiko       =   $request->risiko;
            $data->akibat       =   $request->akibat;
            $data->peluang_id   =   $request->peluang_id;
            $data->indikator   =   $request->indikator;
            $data->nilai_ambang   =   $request->nilai_ambang;
            $data->kriteria_id   =   $request->kriteria_id;
            $data->tanggal       =   date('Y-m-d');
            $data->kategori_id   =   $request->kategori_id;
            $data->klasifikasi_id    =   $request->klasifikasi_id;
            $data->dampak_id    =   $request->dampak_id;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            
            $cekalasan      = Alasan::where('risikobisnis_id',$request->id)->count();
            if($cekalasan>0){
                $alasan      = Alasan::where('risikobisnis_id',$request->id)->first();
                $alasan->sts = 1;
                $alasan->save();

                
            }
            echo'ok';

        }
        
    }

    public function ubah_data(request $request){
        error_reporting(0);
        
            if (trim($request->sumber) == '') {$error[] = '- Isi Sumber terlebih dahulu';}
            if (trim($request->mitigasi) == '') {$error[] = '- Isi Mitigasi terlebih dahulu';}
            if (trim($request->biaya) == '') {$error[] = '- Isi Peluang terlebih dahulu';}
            if (trim($request->file) == '') {$error[] = '- Upload File terlebih dahulu';}
            if (trim($request->start_date) == '') {$error[] = '- Isi Startdate terlebih dahulu';}
            if (trim($request->end_date) == '') {$error[] = '- Isi Enddate terlebih dahulu';}
            if (trim($request->pic) == '') {$error[] = '- Isi PIC terlebih dahulu';}
            if (trim($request->status) == '') {$error[] = '- Isi Status terlebih dahulu';}
            if (isset($error)) {echo '<div style="padding:5px;background:#d1ffae;font-size:12px;width:100%;padding:1%"><b>Error</b>: <br> '.implode(' || ', $error).'</div>';} 
            else{

                $file=$_FILES['file']['name'];
                $size=$_FILES['file']['size'];
                $asli=$_FILES['file']['tmp_name'];
                $ukuran=getimagesize($_FILES["file"]['tmp_name']);
                $tipe=explode('.',$_FILES['file']['name']);
                $filename=date('Ymdhis').'.'.$tipe[1];
                $lokasi='_file/';
                if(move_uploaded_file($asli, $lokasi.$filename)){
                    $data                 = new Sumber;
                    $data->risikobisnis_id         = $request->id;
                    $data->sumber         = $request->sumber;
                    $data->mitigasi       = $request->mitigasi;
                    $data->biaya          = $request->biaya;
                    $data->start_date     = $request->start_date;
                    $data->end_date       = $request->end_date;
                    $data->file            = $filename;
                    $data->pic            = $request->pic;
                    $data->status          = $request->status;
                    $data->save();

                    $cekalasan      = Alasan::where('risikobisnis_id',$request->id)->count();
                    if($cekalasan>0){
                        $alasan      = Alasan::where('risikobisnis_id',$request->id)->first();
                        $alasan->sts = 1;
                        $alasan->save();
                    }
                    echo'ok||'.$request->id;
                }


            }
            
        
    }


}
