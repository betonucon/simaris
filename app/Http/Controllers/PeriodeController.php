<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Periode;
use Session;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
{
    public function index(){
        if(admin()>0){
            $halaman='Daftar Periode';
            $link='periode';
    
            return view('periode.index',compact('halaman','link'));
        }else{
            $halaman='Oops! Page not found.';
            $link='periode';
    
            return view('eror',compact('halaman','link'));
        }
        
    }

   

    public function hapus($id){
        $data=Periode::where('id',$id)->delete();

    }
    public function cek_data($id){
        $data=Periode::where('sts_aktif',1)->update([
            'sts_aktif'=>2,
        ]);

        $data2=Periode::where('id',$id)->update([
            'sts_aktif'=>1,
        ]);

    }
    public function ubah($id){
        
            $data=Periode::where('id',$id)->first();
            echo'
            <input type="text" name="id" value="'.$data['id'].'" class="form-control">
            <div class="form-group">
                <label>Nama Periode</label>
                <input type="text"  name="name"  value="'.$data['name'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>Start Date</label>
                <input type="text"  name="start_date"  id="datepicker3" value="'.$data['start_date'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>End Date</label>
                <input type="text"  name="end_date" id="datepicker4" value="'.$data['end_date'].'" class="form-control">
            </div>
            <div class="form-group">
                <label>Tahun</label>
                <input type="number"  name="tahun"  value="'.$data['tahun'].'" class="form-control">
            </div>

            ';
            
                
           
            
    }
    
    public function view_data(request $request){
        $cek=strlen($request->name);
        echo'
            
            <table class="table table-hover" style="width:98%;margin-left:1%">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Periode</th>
                    <th width="10%">Start date</th>
                    <th width="10%">End date</th>
                    <th width="6%">Tahun</th>
                    <th width="10%">Dibuat</th>
                    <th width="4%"></th>
                    <th width="7%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Periode::where('name','LIKE','%'.$request->name.'%')->orderBy('id','Desc')->get();
                }else{
                    $data=Periode::orderBy('id','Desc')->get();
                }
                // dd($data);
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td class="ttd">'.($no+1).'</td>
                            <td class="ttd">'.$o['name'].'</td>
                            <td class="ttd">'.$o['start_date'].'</td>
                            <td class="ttd">'.$o['end_date'].'</td>
                            <td class="ttd">'.$o['tahun'].'</td>
                            <td class="ttd">'.$o['creator'].'</td>
                            <td class="ttd">';
                            if($o['sts_aktif']==1){
                                echo'
                                <span class="btn btn-danger btn-xs" onclick="uncek('.$o['id'].')"><i class="fa fa-check"></i></span>';
                            }else{
                                echo'
                                <span class="btn btn-default btn-xs" onclick="cek('.$o['id'].')"><i class="fa fa-check"></i></span>';
                            }
                               echo'
                            </td>
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


    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Isi Nama Periode terlebih dahulu';}
        if (trim($request->start_date) == '') {$error[] = '- Isi start date terlebih dahulu';}
        if (trim($request->end_date) == '') {$error[] = '- Isi start date terlebih dahulu';}
        if (trim($request->tahun) == '') {$error[] = '- Isi Tahun terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Periode::where('tahun',$request->tahun)->count();

            $data               =   new Periode;
            $data->name         =   $request->name;
            $data->start_date   =   $request->start_date;
            $data->end_date     =   $request->end_date;
            $data->tahun        =   $request->tahun;
            $data->aktif        =   0;
            $data->deleted      =   0;
            $data->urut         =   ($cek+1);
            $data->sts_aktif    =   0;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            
            echo'ok';
        }
    }

    public function ubah_data(request $request){
        if (trim($request->name) == '') {$error[] = '- Isi Nama Periode terlebih dahulu';}
        if (trim($request->start_date) == '') {$error[] = '- Isi start date terlebih dahulu';}
        if (trim($request->end_date) == '') {$error[] = '- Isi start date terlebih dahulu';}
        if (trim($request->tahun) == '') {$error[] = '- Isi Tahun terlebih dahulu';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data               =   Periode::find($request->id);
            $data->name         =   $request->name;
            $data->start_date   =   $request->start_date;
            $data->end_date     =   $request->end_date;
            $data->tahun        =   $request->tahun;
            $data->creator      =   Auth::user()['kode'];
            $data->save();

            
            echo'ok';
        }
    }
}
