<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Kpi;
use App\Unit;
use PDF;
use Session;
use App\Imports\KpiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KpiController extends Controller
{
    public function index(request $request){
       
        if(admin()>0 || verifikatur()>0){
            $halaman='Daftar KPI';
            $link='KPI';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('kpi.index',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    public function index_keyperson(request $request){
       
        if(keyperson()>0){
            $halaman='Daftar KPI';
            $link='KPI';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
    
            return view('kpi.index_user',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }

    public function index_pimpinanunit(request $request){
       
        if(pimpinanunit()>0){
            $halaman='Daftar KPI';
            $link='KPI';
            $unit_id=$request->unit;
            if($request->periode==''){
                $periode=periode_aktif()['id'];
            }else{
                $periode=$request->periode;
            }
            
    
            return view('kpi.index_pimpinanunit',compact('halaman','link','unit_id','periode'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
    }
    

    public function cari_unit(request $request){
        $cek=strlen($request->name);
        if($cek>0){
            $data=Unit::where('nama','LIKE','%'.$request->name.'%')->orWhere('objectabbr','LIKE','%'.$request->name.'%')->first();
            echo $data['nama'].'/'.$data['objectabbr'];
        }else{
            echo 'null/';
        }
            
    }

    public function hapus($id){
        $data=Kpi::where('id',$id)->delete();

    }

    public function ubah($id){
        
        $data=Kpi::with(['unit'])->where('id',$id)->first();
        echo'
            <input type="hidden" name="id" value="'.$data['id'].'">
            <div class="form-group">
                <label>Kode KPI </label>
                <input type="text"  name="kode"  value="'.$data['kode'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>Nama KPI</label>
                <textarea name="name" class="form-control"  rows="4">'.$data['name'].'</textarea>
            </div>
            <div class="form-group">
                <label>Periode Kwartal</label>
                <select  name="periode_id"   class="form-control">
                    <option value="">Pilih Priode</option>';
                    foreach(periode() as $peri){
                        if($data['periode_id']==$peri['id']){$sel='selected';}else{$sel='';}
                        echo'<option value="'.$peri['id'].'" '.$sel.'>['.$peri['tahun'].'] '.$peri['name'].'</option>';
                    }
                    echo'
                </select>
            </div>';
            if(admin()>0){
            
            
                echo'
                    <div class="form-group">
                        <label>Unit Kerja </label>
                        <input type="text"  onkeyup="cari_unit_ubah(this.value)" placeholder="Cari kode unit atau nama unit" value="" class="form-control">
                        <input type="text"  disabled  id="nama_unit2" value="['.$data['unit_id'].'] '.$data->unit['nama'].'" class="form-control">
                        <input type="hidden"  name="unit_id" value="'.$data['unit_id'].'" id="unit_id2" value="" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Tahun </label>
                        <input type="number"  name="tahun" value="'.$data['tahun'].'" class="form-control">
                    </div>';
            }

            if(keyperson()>0 || pimpinanunit()>0){
            
            
                echo'
                    <div class="form-group">
                        <label>Unit Kerja </label>
                        <input type="text"  disabled  id="nama_unit2" value="['.$data['unit_id'].'] '.$data->unit['nama'].'" class="form-control">
                        <input type="hidden"  name="unit_id" value="'.$data['unit_id'].'" id="unit_id2" value="" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Tahun </label>
                        <input type="text"  disabled value="'.$data['tahun'].'" class="form-control">
                        <input type="hidden"  name="tahun" value="'.$data['tahun'].'" class="form-control">
                    </div>';
            }

        
        
    }

    public function ubah_sts($id){
        
        $data=Kpi::with(['unit'])->where('id',$id)->first();
        echo'
            <input type="hidden" name="id" value="'.$data['id'].'">
            <input type="hidden" name="unit_id" value="'.$data['unit_id'].'">
            <input type="hidden" name="periode_id" value="'.$data['periode_id'].'">
            <div class="form-group">
                <label>Kode KPI </label>
                <input type="text"  name="kode"  value="'.$data['kode'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>Nama KPI</label>
                <textarea name="name" class="form-control"  rows="4">'.$data['name'].'</textarea>
            </div>
            <div class="form-group">
                <label>Level KPI</label>
                <select  name="level"   class="form-control">
                    <option value="0" ';if($data['level']==0){ echo'selected';} echo'>Standar</option>
                    <option value="1" ';if($data['level']==1){ echo'selected';} echo'>Utama</option>
                    <option value="2" ';if($data['level']==2){ echo'selected';} echo'>Paling Utama</option>
                    
                </select>
            </div>
            
            
        ';
        
            
       
        
    }


    public function view_data(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No </th>
                    <th width="7%">Kode KPI</th>
                    <th>Nama KPI</th>
                    <th width="25%">Unit Kerja</th>
                    <th width="6%">Level</th>
                    <th width="6%">Tahun</th>
                    <th width="10%">Kwartal</th>
                    <th width="7%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Kpi::with(['unit','periode'])->where('name','LIKE','%'.$request->name.'%')->orWhere('kode','LIKE','%'.$request->name.'%')->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                }else{
                    // $data=Kpi::with(['unit'])->orderBy('id','Desc')->get();
                    $data=Kpi::with(['unit','periode'])->where('periode_id',$request->periode)->orderBy('kode','Asc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['kode'].'</td>
                            <td class="ttd">'.$o['name'].'</td>
                            <td class="ttd">'.$o->unit['nama'].'</td>
                            <td class="ttd">'.cek_level($o['level']).'</td>
                            <td class="ttd">'.$o['tahun'].'</td>
                            <td class="ttd">'.$o->periode['name'].'</td>
                            <td class="ttd">';
                            if(admin()>0){
                                echo'
                                <span class="btn btn-success btn-xs" onclick="ubah('.$o['id'].')"><i class="fa fa-pencil"></i></span>_
                                <span class="btn btn-danger btn-xs" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span>';
                            }else{
                                echo'
                                <span class="btn btn-default btn-xs" ><i class="fa fa-pencil"></i></span>_
                                <span class="btn btn-default btn-xs" ><i class="fa fa-remove"></i></span>';
                            }
                            echo'
                            </td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }
    
    public function view_data_user(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No</th>
                    <th width="7%">Kode KPI</th>
                    <th>Nama KPI</th>
                    <th width="25%">Unit Kerja</th>
                    <th width="6%">Level</th>
                    <th width="6%">Tahun</th>
                    <th width="10%">Kwartal</th>
                    <th width="5%"></th>
                    <th width="7%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Kpi::with(['unit','periode'])->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                }else{
                    // $data=Kpi::with(['unit'])->orderBy('id','Desc')->get();
                    $data=Kpi::with(['unit','periode'])->where('unit_id',$request->unit)->where('periode_id',$request->periode)->orderBy('kode','Asc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['kode'].'</td>
                            <td class="ttd">'.$o['name'].'</td>
                            <td class="ttd">'.$o->unit['nama'].'</td>
                            <td class="ttd">'.cek_level($o['level']).' </td>
                            <td class="ttd">'.$o['tahun'].'</td>
                            <td class="ttd">'.$o->periode['name'].'</td>
                            <td class="ttd"><span class="btn btn-primary btn-xs" onclick="cek_modal('.$o['id'].')"><i class="fa fa-gear"></i></span></td>
                            <td class="ttd">';
                            if($o->periode['sts_aktif']==1){
                                echo'
                                <span class="btn btn-success btn-xs" onclick="ubah('.$o['id'].')"><i class="fa fa-pencil"></i></span>_
                                <span class="btn btn-danger btn-xs" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span>';
                            }else{
                                echo'
                                <span class="btn btn-default btn-xs" ><i class="fa fa-pencil"></i></span>_
                                <span class="btn btn-default btn-xs" ><i class="fa fa-remove"></i></span>';
                            }
                               echo'
                            </td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function view_data_pimpinanunit(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%;margin-bottom:4%">
                <tr>
                    <th width="5%">No</th>
                    <th width="7%">Kode KPI</th>
                    <th>Nama KPI</th>
                    <th width="25%">Unit Kerja</th>
                    <th width="8%">Level</th>
                    <th width="6%">Tahun</th>
                    <th width="10%">Kwartal</th>
                    <th width="7%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Kpi::with(['unit','periode'])->where('periode_id',$request->periode)->orderBy('id','Desc')->get();
                }else{
                    // $data=Kpi::with(['unit'])->orderBy('id','Desc')->get();
                    $data=Kpi::with(['unit','periode'])->where('unit_id',$request->unit)->where('periode_id',$request->periode)->orderBy('kode','Asc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['kode'].'</td>
                            <td class="ttd">'.$o['name'].'</td>
                            <td class="ttd">'.$o->unit['nama'].'</td>
                            <td class="ttd">'.cek_level($o['level']).'</td>
                            <td class="ttd">'.$o['tahun'].'</td>
                            <td class="ttd">'.$o->periode['name'].'</td>
                            <td class="ttd">
                                <span class="btn btn-success btn-xs" onclick="ubah('.$o['id'].')"><i class="fa fa-pencil"></i></span>_
                                <span class="btn btn-danger btn-xs" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span>
                            </td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function import_data(request $request)
    {
       error_reporting(0);
       if (trim($request->periode_id) == '') {$error[] = '- Pilih Periode';}
       if (trim($request->file) == '') {$error[] = '- Masukan FIle';}
       if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error=</b>: <br />'.implode('<br />', $error).'</p>';} 
       else{
                $filess = $request->file('file');
                $nama_file = rand().$filess->getClientOriginalName();
                $filess->move('file_excel',$nama_file);
                $data = [
                    'periode_id' => $request->periode_id, 
                
                ];
                Excel::import(new KpiImport($data), public_path('/file_excel/'.$nama_file));
                Session::flash('sukses','Data Berhasil Diimport!');
        }
    }

    public function simpan(request $request){
        if (trim($request->kode) == '') {$error[] = '- Isi Kode KPI terlebih dahulu';}
        if (trim($request->name) == '') {$error[] = '- Isi Nama KPI terlebih dahulu';}
        if (trim($request->periode_id) == '') {$error[] = '- Pilih Periode terlebih dahulu';}
        if (trim($request->unit_id) == '') {$error[] = '- Pilih Unit kerja terlebih dahulu';}
        if (trim($request->tahun) == '') {$error[] = '- Isi Tahun terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data               =   new Kpi;
            $data->name         =   $request->name;
            $data->kode         =   $request->kode;
            $data->periode_id   =   $request->periode_id;
            $data->tahun        =   $request->tahun;
            $data->unit_id      =   $request->unit_id;
            $data->level        =   0;
            $data->deleted      =   0;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            
            
            echo'ok';
        }
    }

    public function ubah_data(request $request){
        if (trim($request->kode) == '') {$error[] = '- Isi Kode KPI terlebih dahulu';}
        if (trim($request->name) == '') {$error[] = '- Isi Nama KPI terlebih dahulu';}
        if (trim($request->periode_id) == '') {$error[] = '- Pilih Periode terlebih dahulu';}
        if (trim($request->unit_id) == '') {$error[] = '- Pilih Unit kerja terlebih dahulu';}
        if (trim($request->tahun) == '') {$error[] = '- Isi Tahun terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data               =   Kpi::find($request->id);
            $data->name         =   $request->name;
            $data->kode         =   $request->kode;
            $data->periode_id   =   $request->periode_id;
            $data->tahun        =   $request->tahun;
            $data->unit_id      =   $request->unit_id;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            
            echo'ok';
        }
    }

    public function ubah_data_sts(request $request){
        
           if($request->level==1){
                $data=Kpi::where('level',1)->where('unit_id',$request->unit_id)->where('periode_id',$request->periode_id)->update([
                    'level'=>0,
                ]);
        
                $data2=Kpi::where('id',$request->id)->where('unit_id',$request->unit_id)->where('periode_id',$request->periode_id)->update([
                    'level'=>$request->level,
                ]);
           }

           if($request->level==2){
                $data=Kpi::where('level',2)->where('unit_id',$request->unit_id)->where('periode_id',$request->periode_id)->update([
                    'level'=>0,
                ]);
        
                $data2=Kpi::where('id',$request->id)->where('unit_id',$request->unit_id)->where('periode_id',$request->periode_id)->update([
                    'level'=>$request->level,
                ]);
           }

           if($request->level==0){
                $data2=Kpi::where('id',$request->id)->where('unit_id',$request->unit_id)->where('periode_id',$request->periode_id)->update([
                    'level'=>$request->level,
                ]);
           }

           echo'ok';
            
       
    }
}
