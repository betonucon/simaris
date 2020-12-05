<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kasir;
use PDF;
use Session;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    public function laporan(request $request){
        $link='laporan';
        if($request->mulai==''){
            $mulai=date('Y-m-d');
            $sampai=date('Y-m-d');
        }else{
            $mulai=$request->mulai;
            $sampai=$request->sampai;
        }
        
        return view('laporan.index',compact('link','mulai','sampai'));
    }
    
    public function hapus($id){
        $data=Kasir::where('id',$id)->delete();
        echo'ok';
    }

    public function kirim_email($id){
        $data=Kasir::where('id',$id)->first();
        $update=Kasir::where('id',$id)->update(
            ['sts'=>1]
        );
        $kirim = Mail::to($data['email'])->send(new SendMail($data));
    
        
            echo '<p style="font-size:12px;padding:5px;background:#d1ffae">Email telah dikirim</p>';
        
    }
    public function cek($id){
        $update=Kasir::where('id',$id)->update(
            ['sts'=>2,'tanggal_sts'=>date('Y-m-d')]
        );
        echo'ok';
        
    }
    public function uncek($id){
        $update=Kasir::where('id',$id)->update(
            ['sts'=>1,'tanggal_sts'=>null]
        );
        echo'ok';
        
    }

    public function ubah($id){
        $data=Kasir::where('id',$id)->first();
        echo'
                <input type="hidden" name="id" id="id" value="'.$data['id'].'">
                <div class="form-group">
                    <label>Nama Konsumen </label>
                    <input type="text"  name="name"  value="'.$data['name'].'" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email </label>
                    <input type="email"  name="email"  value="'.$data['email'].'" class="form-control">
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control"  rows="4">'.$data['keterangan'].'</textarea>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text"  name="harga" value="'.$data['harga'].'" id="rupiah" class="form-control">
                </div>';

    }
    public function cetak($id){
        $data=Kasir::where('id',$id)->first();
        echo'
            <input type="hidden" name="idnya" id="idnya" value="'.$data['id'].'">
            <table width="100%" bgcolor="#fff">
                <tr>
                    <td class="ttd" width="10%"></td>
                    <td class="ttd">No</td>
                    <td class="ttd">Keterangan</td>
                    <td class="ttd">Harga</th>
                    <td class="ttd" width="10%">&nbsp;</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td  colspan="3" style="padding:0px;background:#fff" ><hr style="border:dotted 1px #000;margin:0px"></td>
                    <td class="ttd"></td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">1</td>
                    <td class="ttd">'.$data['keterangan'].'</td>
                    <td class="ttd">'.uang($data['harga']).'</td>
                    <td class="ttd"> </td>
                </tr>
            </table>';

    }
    public function view_data(request $request){
        $cek=strlen($request->name);
        echo'
            <table class="table table-hover" id="tampilkan">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">No Voucher</th>
                    <th width="13%">Nama Konsumen</th>
                    <th width="13%">Email</th>
                    <th>Keterangan</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Tanggal</th>
                    <th width="5%">cek</th>
                    <th width="5%">Prin</th>
                    <th width="8%">Act</th>
                </tr>';
                if($cek>0){
                    $data=Kasir::where('name','LIKE','%'.$request->name.'%')->orWhere('tanggal','LIKE','%'.$request->name.'%')->orWhere('notransaksi','LIKE','%'.$request->name.'%')->orderBy('id','Desc')->get();
                }else{
                    $data=Kasir::orderBy('id','Desc')->get();
                }
                
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td>'.($no+1).'</td>
                            <td>'.$o['notransaksi'].'</td>
                            <td>'.$o['name'].'</td>
                            <td>'.$o['email'].'</td>
                            <td>'.$o['keterangan'].'</td>
                            <td>'.uang($o['harga']).'</td>
                            <td>'.$o['tanggal'].'</td>
                            ';
                                if($o['sts']==1 || $o['sts']==0){
                                    echo'<td><span class="btn btn-success btn-xs" onclick="cek('.$o['id'].')"><i class="fa fa-check"></i></span></td>';
                                }else{
                                    echo'<td><span class="btn btn-default btn-xs" onclick="uncek('.$o['id'].')" ><i class="fa fa-close"></i></span></td>';
                                }
                            echo'
                            <td><span class="btn btn-primary btn-xs" onclick="cetak('.$o['id'].')"><i class="fa fa-print"></i></span></td>
                            <td>
                                <span class="btn btn-success btn-xs" onclick="ubah('.$o['id'].')"><i class="fa fa-pencil"></i></span>_
                                <span class="btn btn-danger btn-xs" onclick="hapus('.$o['id'].')"><i class="fa fa-remove"></i></span>
                            </td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function view_laporan(request $request){
        
        echo'
            <div class="callout callout-info">
            <h4>Total Transaksi :'.uang(total_transaksi($request->mulai,$request->sampai)).'</h4>

            </div>
            <table class="table table-hover" id="tampilkan">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">No Voucher</th>
                    <th width="25%">Nama Konsumen</th>
                    <th>Keterangan</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Tanggal</th>
                </tr>';
                
                $data=Kasir::whereBetween('tanggal',[$request->mulai,$request->sampai])->orderBy('id','Desc')->get();
                
                foreach($data as $no=>$o){
                    echo'    
                        <tr>
                            <td>'.($no+1).'</td>
                            <td>'.$o['notransaksi'].'</td>
                            <td>'.$o['name'].'</td>
                            <td>'.$o['keterangan'].'</td>
                            <td>'.uang($o['harga']).'</td>
                            <td>'.$o['tanggal'].'</td>
                         </tr>';
                }
         echo'
            </table>
        ';
    }

    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Nama  harus diisi';}
        if (trim($request->email) == '') {$error[] = '- Email  harus diisi';}
        if (trim($request->keterangan) == '') {$error[] = '- Keterangan  harus diisi';}
        if (trim($request->harga) == '') {$error[] = '- Harga harus diisi';}
        if (isset($error)) {echo '<p style="font-size:12px;padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $patr='/([^0-9]+)/';
            $harga=preg_replace($patr,'',$request->harga);


            $data               =new Kasir;
            $data->notransaksi  = date('Ymdhis');
            $data->tanggal      = date('Y-m-d');
            $data->email         = $request->email;
            $data->name         = $request->name;
            $data->keterangan   = $request->keterangan;
            $data->harga        = $harga;
            $data->sts          = 0;
            $data->save();

            if($data){
                echo'ok|'.$data['id'];
            }
        }
    }

    public function ubah_data(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama  harus diisi';}
        if (trim($request->keterangan) == '') {$error[] = '- Keterangan  harus diisi';}
        if (trim($request->harga) == '') {$error[] = '- Harga harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $patr='/([^0-9]+)/';
            $harga=preg_replace($patr,'',$request->harga);


            $data               = Kasir::find($id);
            $data->name         = $request->name;
            $data->keterangan   = $request->keterangan;
            $data->harga        = $harga;
            $data->save();

            if($data){
                echo'ok';
            }
        }
    }

    public function cetak_pdf($mulai,$sampai){
       
        error_reporting(0);
        $data=Kasir::whereBetween('tanggal',[$mulai,$sampai])->orderBy('id','Desc')->get();

        $pdf = PDF::loadView('pdf.index', ['data'=>$data,'mulai'=>$mulai,'sampai'=>$sampai]);
        return $pdf->stream();
        
    }
}
