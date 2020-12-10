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

class LaporanrisikoController extends Controller
{
    public function index(request $request){
       
        if(keyperson()>0){
            $halaman='Laporan Risiko Bisnis';
            $link='laporan_risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('laporan_risiko.index',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }
    public function index_user(request $request){
       
        if(verifikatur()>0 || pimpinangcg()>0){
            $halaman='Laporan Risiko Bisnis';
            $link='risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('laporan_risiko.index_verifikatur',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }
    public function index_pimpinansubdit(request $request){
       
        if(pimpinansubdit()>0){
            $halaman='Laporan Risiko Bisnis '.cek_unit($request->unit)['nama'];
            $link='risiko';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            // dd(unit_bawahan_subdit($unit_id));
    
            return view('laporan_risiko.index_pimpinansubdit',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    

    public function view_data(request $request){
        $cek=strlen($request->name);
        echo'
            <style>
                th{
                    font-size:12px;
                    background:#b0e6e6;
                    border:solid 1px #000;
                    text-align:center;
                    padding:5px;
                    text-transform:uppercase;
                }
                td{
                    font-size:12px;
                    border:solid 1px #000;
                    vertical-align:top;
                    padding:5px;
                }
            </style>
            <table  style="width:98%;margin-left:1%">
                <tr>
                    <th rowspan="2" width="5%">No</th>
                    <th rowspan="2">KPI</th>
                    <th rowspan="2" width="11%">Nama Risiko</th>
                    <th rowspan="2" width="11%">Sumber risiko</th>
                    <th rowspan="2" width="11%">Akibat</th>
                    <th rowspan="2" width="11%">Tingkat Risiko</th>
                    <th colspan="4">Respon Risiko</th>
                    
                </tr>
                <tr>
                    <th width="11%">Mitigasi</th> 
                    <th width="10%">Target</th> 
                    <th width="9%">PIC</th> 
                    <th width="6%">Status</th> 
                </tr>';
                if($cek>0){
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('periode_id',$request->periode)->where('sts',4)->orderBy('id','Desc')->get();
                }else{
                    // $data=Risikobisnis::with(['unit'])->orderBy('id','Desc')->get();
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('unit_id',$request->unit)->where('periode_id',$request->periode)->where('sts',4)->orderBy('id','Desc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    foreach(get_sumber($o['id']) as $xx=>$sumber){
                    
                        echo'    
                            <tr >';
                            if($xx==0){
                                echo'
                                <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.($no+1).'</td>
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o->kpi['name'].'</td>
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['risiko'].'</td>';
                            }
                                echo'
                                <td class="ttd">'.$sumber['sumber'].'</td>';
                            if($xx==0){
                                echo'
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['akibat'].'</td>
                                <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</td>';
                            }
                                echo'
                                <td class="ttd">'.$sumber['mitigasi'].'</td>
                                <td class="ttd">'.$sumber['start_date'].' s/d '.$sumber['end_date'].'</td>
                                <td class="ttd">'.$sumber['pic'].'</td>
                                <td class="ttd">'.$sumber['status'].'</td>
                                
                                
                            </tr>';
                    }
                }
         echo'
            </table>
        ';
    }

    public function view_data_pimpinansubdit(request $request){
        $cek=strlen($request->name);
        echo'
            <style>
                th{
                    font-size:12px;
                    background:#b0e6e6;
                    border:solid 1px #000;
                    text-align:center;
                    padding:5px;
                    text-transform:uppercase;
                }
                td{
                    font-size:12px;
                    border:solid 1px #000;
                    vertical-align:top;
                    padding:5px;
                }
            </style>';
            foreach(unit_bawahan_subdit($request->unit) as $uni){
                echo'
                    <table  style="width:98%;margin-left:1%">
                        <tr>
                            <th colspan="10" style="text-align:left">'.$uni['nama'].'</th>
                        </tr>
                        <tr>
                            <th rowspan="2" width="5%">No</th>
                            <th rowspan="2">KPI</th>
                            <th rowspan="2" width="11%">Nama Risiko</th>
                            <th rowspan="2" width="11%">Sumber risiko</th>
                            <th rowspan="2" width="11%">Akibat</th>
                            <th rowspan="2" width="11%">Tingkat Risiko</th>
                            <th colspan="4">Respon Risiko</th>
                            
                        </tr>
                        <tr>
                            <th width="11%">Mitigasi</th> 
                            <th width="10%">Target</th> 
                            <th width="9%">PIC</th> 
                            <th width="6%">Status</th> 
                        </tr>';
                        if($cek>0){
                            $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('unit_id',$uni['objectabbr'])->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                        }else{
                            // $data=Risikobisnis::with(['unit'])->orderBy('id','Desc')->get();
                            $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('unit_id',$uni['objectabbr'])->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                        }
                        // dd($data);
                        foreach($data as $no=>$o){
                            foreach(get_sumber($o['id']) as $xx=>$sumber){
                            
                                echo'    
                                    <tr >';
                                    if($xx==0){
                                        echo'
                                        <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.($no+1).'</td>
                                        <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o->kpi['name'].'</td>
                                        <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['risiko'].'</td>';
                                    }
                                        echo'
                                        <td class="ttd">'.$sumber['sumber'].'</td>';
                                    if($xx==0){
                                        echo'
                                        <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['akibat'].'</td>
                                        <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</td>';
                                    }
                                        echo'
                                        <td class="ttd">'.$sumber['mitigasi'].'</td>
                                        <td class="ttd">'.$sumber['start_date'].' s/d '.$sumber['end_date'].'</td>
                                        <td class="ttd">'.$sumber['pic'].'</td>
                                        <td class="ttd">'.$sumber['status'].'</td>
                                        
                                        
                                    </tr>';
                            }
                        }
                    echo'
                    </table><br><br>
                    ';
            }
    }

    public function laporan_risiko(request $request){
        
        $tampil='
            <style>
                th{
                    font-size:12px;
                    background:#b0e6e6;
                    border:solid 1px #000;
                    text-align:center;
                    padding:5px;
                    text-transform:uppercase;
                }
                td{
                    font-size:12px;
                    border:solid 1px #000;
                    vertical-align:top;
                    padding:5px;
                }
            </style>
            <table  style="width:98%;margin-left:1%;border-collapse:collapse">
                <tr>
                    <th rowspan="2" width="5%">No</th>
                    <th rowspan="2">KPI</th>
                    <th rowspan="2" width="11%">Nama Risiko</th>
                    <th rowspan="2" width="11%">Sumber risiko</th>
                    <th rowspan="2" width="11%">Akibat</th>
                    <th rowspan="2" width="11%">Tingkat Risiko</th>
                    <th colspan="4">Respon Risiko</th>
                    
                </tr>
                <tr>
                    <th width="11%">Mitigasi</th> 
                    <th width="10%">Target</th> 
                    <th width="9%">PIC</th> 
                    <th width="6%">Status</th> 
                </tr>';
                
                $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('unit_id',$request->unit)->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                $judul=cek_unit($request->unit)['nama'];
                foreach($data as $no=>$o){
                    foreach(get_sumber($o['id']) as $xx=>$sumber){
                    
                        $tampil.='   
                            <tr >';
                            if($xx==0){
                                $tampil.='
                                <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.($no+1).'</td>
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o->kpi['name'].'</td>
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['risiko'].'</td>';
                            }
                                $tampil.='
                                <td class="ttd">'.$sumber['sumber'].'</td>';
                            if($xx==0){
                                $tampil.='
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['akibat'].'</td>
                                <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</td>';
                            }
                                $tampil.='
                                <td class="ttd">'.$sumber['mitigasi'].'</td>
                                <td class="ttd">'.$sumber['start_date'].' s/d '.$sumber['end_date'].'</td>
                                <td class="ttd">'.$sumber['pic'].'</td>
                                <td class="ttd">'.$sumber['status'].'</td>
                                
                                
                            </tr>';
                    }
                }
            $tampil.='
            </table>
        ';

       
        return view('laporan_risiko.laporan_index',compact('tampil','judul'));
    }

    public function laporan_risiko_subdit(request $request){
        
        $tampil='
            <style>
                th{
                    font-size:12px;
                    background:#b0e6e6;
                    border:solid 1px #000;
                    text-align:center;
                    padding:5px;
                    text-transform:uppercase;
                }
                td{
                    font-size:12px;
                    border:solid 1px #000;
                    vertical-align:top;
                    padding:5px;
                }
            </style>';
            $judul=cek_unit($request->unit)['nama'];
            foreach(unit_bawahan_subdit($request->unit) as $uni){
                $tampil.='
                    <table  style="width:98%;margin-left:1%;border-collapse:collapse">
                        <tr>
                            <th colspan="10" style="text-align:left">'.$uni['nama'].'</th>
                        </tr>
            
           
                        <tr>
                            <th rowspan="2" width="5%">No</th>
                            <th rowspan="2">KPI</th>
                            <th rowspan="2" width="11%">Nama Risiko</th>
                            <th rowspan="2" width="11%">Sumber risiko</th>
                            <th rowspan="2" width="11%">Akibat</th>
                            <th rowspan="2" width="11%">Tingkat Risiko</th>
                            <th colspan="4">Respon Risiko</th>
                            
                        </tr>
                        <tr>
                            <th width="11%">Mitigasi</th> 
                            <th width="10%">Target</th> 
                            <th width="9%">PIC</th> 
                            <th width="6%">Status</th> 
                        </tr>';
                        
                            $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria'])->where('unit_id',$uni['objectabbr'])->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                        
                        foreach($data as $no=>$o){
                            foreach(get_sumber($o['id']) as $xx=>$sumber){
                            
                                $tampil.='   
                                    <tr >';
                                    if($xx==0){
                                        $tampil.='
                                        <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.($no+1).'</td>
                                        <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o->kpi['name'].'</td>
                                        <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['risiko'].'</td>';
                                    }
                                        $tampil.='
                                        <td class="ttd">'.$sumber['sumber'].'</td>';
                                    if($xx==0){
                                        $tampil.='
                                        <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['akibat'].'</td>
                                        <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</td>';
                                    }
                                        $tampil.='
                                        <td class="ttd">'.$sumber['mitigasi'].'</td>
                                        <td class="ttd">'.$sumber['start_date'].' s/d '.$sumber['end_date'].'</td>
                                        <td class="ttd">'.$sumber['pic'].'</td>
                                        <td class="ttd">'.$sumber['status'].'</td>
                                        
                                        
                                    </tr>';
                            }
                        }
                    $tampil.='
                        <tr>
                            <td colspan="10">&nbsp;</td>
                        </tr>
                    </table>
            ';

         }
        return view('laporan_risiko.laporan_index',compact('tampil','judul'));
    }

    public function view_data_verifikatur(request $request){
        $cek=strlen($request->unit);
        echo'
            <style>
                th{
                    font-size:12px;
                    background:#b0e6e6;
                    border:solid 1px #000;
                    text-align:center;
                    padding:5px;
                    text-transform:uppercase;
                }
                td{
                    font-size:12px;
                    border:solid 1px #000;
                    vertical-align:top;
                    padding:5px;
                }
                .ttd{
                    font-size:12px;
                    border:solid 1px #000;
                    vertical-align:top;
                    padding:5px;
                }
            </style>
            <table style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th rowspan="2" width="5%">No</th>
                    <th rowspan="2">KPI</th>
                    <th rowspan="2" width="11%">Nama Risiko</th>
                    <th rowspan="2" width="11%">Sumber risiko</th>
                    <th rowspan="2" width="11%">Akibat</th>
                    <th rowspan="2" width="11%">Tingkat Risiko</th>
                    <th colspan="4">Respon Risiko</th>
                    
                </tr>
                <tr>
                    <th width="11%">Mitigasi</th> 
                    <th width="10%">Target</th> 
                    <th width="9%">PIC</th> 
                    <th width="6%">Status</th> 
                </tr>';
                if($cek>0){
                    
                    $unit=cek_unit($request->unit)['nama'];
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->where('periode_id',$request->periode)->where('unit_id',$request->unit)->orderBy('id','Desc')->get();
                }else{
                    $data=Risikobisnis::with(['kpi','unit','periode','dampak','peluang','kriteria','kelompok'])->where('periode_id',$request->periode)->where('unit_id','xxxxx')->orderBy('id','Desc')->paginate(100);
                }
                // dd($data);
                foreach($data as $no=>$o){
                    foreach(get_sumber($o['id']) as $xx=>$sumber){
                    
                        echo'    
                            <tr >';
                            if($xx==0){
                                echo'
                                <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.($no+1).'</td>
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o->kpi['name'].'</td>
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['risiko'].'</td>';
                            }
                                echo'
                                <td class="ttd">'.$sumber['sumber'].'</td>';
                            if($xx==0){
                                echo'
                                <td class="ttd" rowspan="'.jum_sumber($o['id']).'">'.$o['akibat'].'</td>
                                <td class="ttd" align="center" rowspan="'.jum_sumber($o['id']).'">'.matrik($o['peluang_id'],$o['dampak_id'])['tingkat'].'</td>';
                            }
                                echo'
                                <td class="ttd">'.$sumber['mitigasi'].'</td>
                                <td class="ttd">'.$sumber['start_date'].' s/d '.$sumber['end_date'].'</td>
                                <td class="ttd">'.$sumber['pic'].'</td>
                                <td class="ttd">'.$sumber['status'].'</td>
                                
                                
                            </tr>';
                    }
                }
         echo'
            </table>
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
        if (trim($request->indikator) == '') {$error[] = '- Isi Indikator terlebih dahulu';}
        if (trim($request->nilai_ambang) == '') {$error[] = '- Isi Nilai Ambang terlebih dahulu';}
        if (trim($request->kriteria_id) == '') {$error[] = '- Pilih Kriteria terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $per=explode('/',$request->kriteria_id);
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
            $data->kriteria_id   =   $per[0];
            $data->tanggal       =   date('Y-m-d');
            $data->kategori_id   =   $per[1];
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
            if($request->sts==0){
                if($request->keterangan==''){
                    echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />- Masukan Alasan kenapa dikembalikan</p>';
                }else{
                    $data               =   Risikobisnis::find($request->risikobisnis_id);
                    $data->sts          =   0;
                    $data->save();

                    if($data){
                        $alasan     = new Alasan;
                        $alasan->risikobisnis_id = $request->risikobisnis_id;
                        $alasan->periode_id = $cek['periode_id'];
                        $alasan->unit_id = $cek['unit_id'];
                        $alasan->keterangan = $request->keterangan;
                        $alasan->sts = 0;
                        $alasan->save();

                        echo'ok|'.$cek['unit_id'];
                    }
                }
                    
            }else{
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
        if (trim($request->indikator) == '') {$error[] = '- Isi Indikator terlebih dahulu';}
        if (trim($request->nilai_ambang) == '') {$error[] = '- Isi Nilai Ambang terlebih dahulu';}
        if (trim($request->kriteria_id) == '') {$error[] = '- Pilih Kriteria terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $per=explode('/',$request->kriteria_id);
            $data               =   Risikobisnis::find($request->id);
            $data->risiko       =   $request->risiko;
            $data->akibat       =   $request->akibat;
            $data->peluang_id   =   $request->peluang_id;
            $data->indikator   =   $request->indikator;
            $data->nilai_ambang   =   $request->nilai_ambang;
            $data->kriteria_id   =   $per[0];
            $data->tanggal       =   date('Y-m-d');
            $data->kategori_id   =   $per[1];
            $data->klasifikasi_id    =   $request->klasifikasi_id;
            $data->dampak_id    =   $request->dampak_id;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            if($data){
                $alasan      = Alasan::where('risikobisnis_id',$request->id)->first();
                $alasan->sts = 1;
                $alasan->save();
                echo'ok';
            }

        }
        
    }

    public function ubah_data(request $request){
        error_reporting(0);
        
            for($x=0;$x<11;$x++){
                if($request->sumber[$x]=='' || $request->mitigasi[$x]==''){

                }else{
                    if($request->sumber_id[$x]==''){
                        $data               = new Sumber;
                        $data->risikobisnis_id       = $request->id;
                        $data->sumber       = $request->sumber[$x];
                        $data->mitigasi     = $request->mitigasi[$x];
                        $data->biaya        = $request->biaya[$x];
                        $data->pic          = $request->pic[$x];
                        $data->status       = $request->status[$x];
                        $data->start_date   = $request->start_date[$x];
                        $data->end_date     = $request->end_date[$x];
                        $data->urut         = ($x+1);
                        $data->save();
                    }else{
                        $data               =Sumber::find($request->sumber_id[$x]);
                        $data->risikobisnis_id       = $request->id;
                        $data->sumber       = $request->sumber[$x];
                        $data->mitigasi     = $request->mitigasi[$x];
                        $data->biaya        = $request->biaya[$x];
                        $data->pic          = $request->pic[$x];
                        $data->status       = $request->status[$x];
                        $data->start_date   = $request->start_date[$x];
                        $data->end_date     = $request->end_date[$x];
                        $data->save();
                    }
                    
                }
            }

            $alasan      = Alasan::where('risikobisnis_id',$request->id)->first();
            $alasan->sts = 1;
            $alasan->save();
                
            echo'ok';
        
    }


}
