<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\Unit;
use App\Periode;
use App\Hasrole;
use Session;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index(){
        if(admin()>0){
            $halaman='Daftar Otorisasi Pengguna';
            $link='admin';
    
            return view('admin.index',compact('halaman','link'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
        
    }

    public function index_unit(){
        if(admin()>0){
            $halaman='Daftar Unit Kerja';
            $link='unit';
    
            return view('unit.index',compact('halaman','link'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
        
    }

    public function index_user(){
        if(admin()>0){
            $halaman='Daftar  Pengguna';
            $link='admin';
    
            return view('admin.index_user',compact('halaman','link'));
        }else{
            $halaman='Oops! Page not found.';
            $link='admin';
    
            return view('eror',compact('halaman','link'));
        }
        
    }

    public function cari_nik(request $request){
        $cek=strlen($request->name);
        if($cek>0){
            $data=User::where('name','LIKE','%'.$request->name.'%')->orWhere('kode','LIKE','%'.$request->name.'%')->first();
            echo $data['name'].'/'.$data['kode'];
        }else{
            echo 'null/';
        }
            
    }

    public function ubah_unit($id){
        $data=Unit::where('id',$id)->first();
        echo'
            <div class="form-group">
                <label>Kode Unit </label>
                <input type="text"  disabled  id="kode" value="'.$data['kode'].'" class="form-control">
                <input type="hidden"  name="id"  id="kode" value="'.$data['id'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>Objectabbr </label>
                <input type="text"    id="objectabbr" disabled value="'.$data['objectabbr'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>Nama </label>
                <input type="text"  name="nama"  id="nama" value="'.$data['nama'].'" class="form-control">
            </div>

        ';

    }
    public function hapus($id){
        $data=Hasrole::where('id',$id)->delete();

    }
    public function hapus_unit($id){
        $data=Unit::where('id',$id)->delete();

    }

    public function view_data(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">NIK</th>
                    <th>Nama</th>
                    <th width="20%">Role</th>
                    <th width="20%">Role</th>
                    <th width="4%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Hasrole::with(['user','role','unit'])->where('kode','LIKE','%'.$request->name.'%')->orderBy('id','Desc')->get();
                }else{
                    $data=Hasrole::with(['user','role','unit'])->orderBy('id','Desc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['kode'].'</td>
                            <td class="ttd">'.$o->user['name'].'</td>
                            <td class="ttd">'.$o->role['name'].'</td>
                            <td class="ttd">'.$o->unit['nama'].'</td>
                            <td class="ttd">
                                <span class="btn btn-danger btn-xs" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span>
                            </td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function view_data_unit(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Kode Unit</th>
                    <th>Nama</th>
                    <th width="8%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Unit::where('objectabbr','LIKE','%'.$request->name.'%')->orWhere('nama','LIKE','%'.$request->name.'%')->orderBy('nama','Asc')->get();
                }else{
                    $data=Unit::orderBy('nama','Asc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['objectabbr'].'</td>
                            <td class="ttd">'.$o['nama'].'</td>
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

    public function view_data_user(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">NIK</th>
                    <th>Nama</th>
                    <th width="4%">Act</th>
                </tr>';
                if($cek>0){
                    $data=User::where('kode','LIKE','%'.$request->name.'%')->orWhere('name','LIKE','%'.$request->name.'%')->orderBy('id','Desc')->get();
                }else{
                    $data=User::orderBy('id','Desc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['kode'].'</td>
                            <td class="ttd">'.$o['name'].'</td>
                            <td class="ttd">
                                <span class="btn btn-danger btn-xs" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span>
                            </td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function simpan_user(request $request){
        if (trim($request->kode) == '') {$error[] = '- Isi NIK Pengguna terlebih dahulu';}
        if (trim($request->email) == '') {$error[] = '- Isi Email Pengguna terlebih dahulu';}
        if (trim($request->name) == '') {$error[] = '- Isi Nama Pengguna terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=User::whereIn('kode',$request->kode)->count();
            if($cek>0){
                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />- Pengguna sudah terdaftar</p>';
            }else{
                
                    $data               =   new User;
                    $data->kode         =   $request->kode;
                    $data->name         =   $request->name;
                    $data->email        =   $request->email;
                    $data->password     =   Hash::make($request->kode);
                    $data->save();

                    echo'ok';
               
            }
            
            
        }
    }

    public function simpan_unit(request $request){
        if (trim($request->kode) == '') {$error[] = '- Isi Kode Unit terlebih dahulu';}
        if (trim($request->objectabbr) == '') {$error[] = '- Isi objectabbr Unit terlebih dahulu';}
        if (trim($request->nama) == '') {$error[] = '- Isi Nama Unit terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Unit::where('kode',$request->kode)->orWhere('objectabbr',$request->objectabbr)->count();
            if($cek>0){
                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />- Unit Sudah terdaftar</p>';
            }else{
                $sts=explode('subdit',$request->nama);
                $cekun=count($sts);
                if($cekun>1){
                    $stsunit=1;
                }else{
                    $stsunit=0;
                }
                
                    $data               =   new Unit;
                    $data->kode         =   $request->kode;
                    $data->objectabbr   =   $request->objectabbr;
                    $data->nama        =   $request->nama;
                    $data->sts_unit        =   $stsunit;
                    $data->save();

                    echo'ok';
               
            }
            
            
        }
    }

    public function ubah_data_unit(request $request){
        if (trim($request->nama) == '') {$error[] = '- Isi Nama Unit terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $sts=explode('subdit',$request->nama);
            $cekun=count($sts);
            
            if($cekun>1){
                $stsunit=1;
            }else{
                $stsunit=null;
            }
                
                    $data               =   Unit::find($request->id);
                    $data->nama         =   $request->nama;
                    $data->sts_unit        =   $stsunit;
                    $data->save();

                    echo'ok';
            
            
        }
    }

    public function simpan(request $request){
        if (trim($request->kode) == '') {$error[] = '- Isi Nama Pengguna terlebih dahulu';}
        if (trim($request->role_id) == '') {$error[] = '- Pilih Role terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Hasrole::where('kode',$request->kode)->whereIn('kode',[3,4,5])->count();
            if($cek>0){
                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />- Pengguna sudah memiliki akses dirole ini</p>';
            }else{
                if($request->role_id==1 || $request->role_id==3 || $request->role_id==6){
                    if($request->unit_id==''){
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />- Pilih Unit Kerja</p>';
                    }else{
                        $data               =   new Hasrole;
                        $data->kode         =   $request->kode;
                        $data->role_id      =   $request->role_id;
                        $data->unit_id      =   $request->unit_id;
                        $data->save(); 

                        echo'ok';
                    }
                }else{
                    $data               =   new Hasrole;
                    $data->kode         =   $request->kode;
                    $data->role_id      =   $request->role_id;
                    $data->save();

                    echo'ok';
                }
            
            }
            
            
        }
    }

}
