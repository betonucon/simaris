<?php

namespace App\Http\Controllers;
use App\Title;
use PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{
    public function index(request $request){
        $link='title';
        $halaman='Judul Halaman';

        return view('title.index',compact('link','halaman'));
    }

    public function tambah(request $request){
        $link='title/tambah';
        $batal='title';
        $halaman='Tambah Halaman';

        return view('title.tambah',compact('link','batal','halaman'));
    }

    public function ubah(request $request,$id){
        $link='title/ubah';
        $batal='title';
        $halaman='Ubah Halaman';
        $data=Title::where('id',$id)->first();
        return view('title.ubah',compact('link','batal','halaman','data'));
    }


    public function simpan(request $request){
        if(Auth::user()['role_id']==1){
            if (trim($request->name) == '') {$error[] = '- Nama Link  harus diisi';}
            if (trim($request->title) == '') {$error[] = '- Judul  harus diisi';}
            if (trim($request->isi) == '') {$error[] = '- Keterangan  harus diisi';}
            if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
               
               
                $data                   = new Title;
                $data->name             = $request->name;    
                $data->isi              = $request->isi;    
                $data->title            = $request->title;    
                $data->save(); 

                echo'ok';
                   
            }
        }else{
            
        }
    }


    public function simpan_ubah(request $request,$id){
        if(Auth::user()['role_id']==1){
            if (trim($request->name) == '') {$error[] = '- Nama Link  harus diisi';}
            if (trim($request->title) == '') {$error[] = '- Judul  harus diisi';}
            if (trim($request->isi) == '') {$error[] = '- Keterangan  harus diisi';}
            if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
               
               
                $data                   = Title::find($id);
                $data->name             = $request->name;    
                $data->isi              = $request->isi;    
                $data->title            = $request->title;    
                $data->save(); 

                echo'ok';
                   
            }
        }else{
            
        }
    }


    public function api(){
        error_reporting(0);
        if(Auth::user()['role_id']==1){
            
            $data=Title::orderBy('name','Asc')->get();
            
            foreach($data as $o){
            
                $show[]=array(
                    "id" =>$o['id'],
                    "title" =>$o['title'],
                    "isi" =>$o['isi'],
                    "name" =>$o['name']
                );
            }
            echo json_encode($show);
        }else{
            $show[]=array();

            echo json_encode($show);
        }

        
        
    }

    public function hapus(request $request){
        if(Auth::user()['role_id']==1){
            $jum=count($request->id);

            for($x=0;$x<$jum;$x++){
                $data=Title::where('id',$request->id[$x])->delete();
            }
           
        }
    }
}
