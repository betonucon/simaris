<?php
function url_link(){
   $data='';

   return $data;
}
function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}

function bln($id){
   if($id>9){
      $data=$id;
   }else{
      $data='0'.$id; 
   }

   return $data;
}

function uang($id){
   $data=number_format($id,0);

   return $data;
}

function periode(){
   $data=App\Periode::orderBy('id','Desc')->get();
   return $data;
}

function kelompok(){
   $data=App\Kelompok::orderBy('id','Desc')->get();
   return $data;
}


function dampak(){
   $data=App\Dampak::orderBy('id','Desc')->get();
   return $data;
}

function get_kriteria($dampakid,$kategoriid,$level){
   $data=App\Kriteria::where('dampak_id',$dampakid)->where('kategori_id',$kategoriid)->where('level',$level)->get();
   return $data;
}
function klasifikasi(){
   $data=App\Klasifikasi::orderBy('id','Desc')->get();
   return $data;
}

function peluang(){
   $data=App\Peluang::orderBy('id','Desc')->get();
   return $data;
}

function get_kpi($unit,$periode){
   $data=App\Kpi::where('unit_id',$unit)->where('periode_id',$periode)->orderBy('kode','Asc')->get();
   return $data;
}
function get_alasan($unit,$periode,$role){
   $data=App\Alasan::where('unit_id',$unit)->where('role_id',$role)->where('periode_id',$periode)->where('sts',0)->orderBy('id','Desc')->get();
   return $data;
}
function jum_alasan($id,$role){
   $data=App\Alasan::where('risikobisnis_id',$id)->where('role_id',$role)->where('sts',0)->count();
   return $data;
}

function periode_aktif(){
   $data=App\Periode::where('sts_aktif',1)->first();
   return $data;
}

function matrik($peluang,$dampak){
   $data=App\Matrik::where('peluang_id',$peluang)->where('dampak_id',$dampak)->first();
   return $data;
}

function total_kpi_unit($unit,$periode){
   $data=App\Kpi::where('unit_id',$unit)->where('periode_id',$periode)->count();
   return $data;
}
function total_risiko($unit,$periode){
   $data=App\Risikobisnis::where('unit_id',$unit)->where('periode_id',$periode)->where('sts',1)->count();
   return $data;
}
function total_risiko_validasi($unit,$periode){
   $data=App\Risikobisnis::where('unit_id',$unit)->where('periode_id',$periode)->where('sts',2)->count();
   return $data;
}

function total_kpi_unit_utama($unit,$periode){
   $data=App\Kpi::where('unit_id',$unit)->where('periode_id',$periode)->where('level',1)->count();
   return $data;
}

function total_kpi_unit_proses($unit,$periode){
   $data=App\Kpi::where('unit_id',$unit)->where('periode_id',$periode)->where('sts',1)->count();
   return $data;
}

function total_kpi_unit_keypersson($unit,$periode){
   $data=App\Risikobisnis::where('unit_id',$unit)->where('periode_id',$periode)->where('sts','>=',1)->count();
   return $data;
}

function total_kpi_unit_verifikatur($unit,$periode){
   $data=App\Risikobisnis::where('unit_id',$unit)->where('periode_id',$periode)->where('sts','>=',2)->count();
   return $data;
}

function total_kpi_unit_pimpinan($unit,$periode){
   $data=App\Risikobisnis::where('unit_id',$unit)->where('periode_id',$periode)->where('sts','>=',3)->count();
   return $data;
}

function total_kpi_unit_palingutama($unit,$periode){
   $data=App\Kpi::where('unit_id',$unit)->where('periode_id',$periode)->where('level',2)->count();
   return $data;
}

function cek_sumber_risiko($id){
   $data=App\Sumber::where('risikobisnis_id',$id)->count();
   return $data;
}
//cekcccccc
function unit(){
   $data=App\Unit::orderBy('nama','Desc')->get();
   return $data;
}
function unit_subdit(){
   $data=App\Unit::where('sts_unit',1)->orderBy('nama','Desc')->get();
   return $data;
}
function unit_bawahan_subdit($id){
   $unit=substr($id,0,2);
   $data=App\Unit::where('objectabbr','LIKE','%'.$unit.'%')->orderBy('objectabbr','Asc')->get();
   return $data;
}
function cek_unit($id){
   $data=App\Unit::where('objectabbr',$id)->first();
   return $data;
}
function get_sumber($id){
   $data=App\Sumber::where('risikobisnis_id',$id)->get();
   return $data;
}
function jum_sumber($id){
   $data=App\Sumber::where('risikobisnis_id',$id)->count();
   return $data;
}
function cek_sumber($id,$urut){
   $data=App\Sumber::where('risikobisnis_id',$id)->where('urut',$urut)->first();
   return $data;
}

function cek_kaidah($id){
   if($id==0){
      $data='<span class="btn btn-default btn-xs" title="Proses"><i class="fa fa-gear"></i></span>';
   }
   if($id==1){
      $data='<span class="btn btn-primary btn-xs" title="setuju"><i class="fa fa-thumbs-up"></i></span>';
   }
   if($id==2){
      $data='<span class="btn btn-success btn-xs" title="Tidak setuju"><i class="fa fa-thumbs-down"></i></span>';
   }
   return $data;
}

function cek_kaidah_verifikatur($id,$no){
   if($id==0){
      $data='<span class="btn btn-default btn-xs" onclick="cek_kaidah('.$no.')" title="Proses"><i class="fa fa-gear"></i></span>';
   }
   if($id==1){
      $data='<span class="btn btn-primary btn-xs" onclick="cek_kaidah('.$no.')"title="setuju"><i class="fa fa-thumbs-up"></i></span>';
   }
   if($id==2){
      $data='<span class="btn btn-success btn-xs" onclick="cek_kaidah('.$no.')" title="Tidak setuju"><i class="fa fa-thumbs-down"></i></span>';
   }
   return $data;
}

function role(){
   $data=App\Role::orderBy('name','Desc')->get();
   return $data;
}

function cek_level($id){
   $data=App\Level::where('id',$id)->first();
   if($id==0){
      $tam='<span class="label label-default"><i>Standar</i></span>';
   }else{
      $tam='<span class="label label-'.$data['warna'].'"><b>'.$data['nama'].'</b></span>';
   }
   return $tam;
}

function cek_role($id){
   if($id==0){
      $tam='<span class="btn btn-default"><i class="fa fa-remove"></i></span>';
   }else{
      $tam='<span class="btn btn-danger"><i class="fa fa-check"></i></span>';
   }
   return $tam;
}

function admin(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',5)->count();
   return $data;
}

function verifikatur(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',2)->count();
   return $data;
}

function pimpinanunit(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',3)->count();
   return $data;
}

function unit_pimpinanunit(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',3)->get();
   return $data;
}

function keyperson(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',1)->count();
   return $data;
}

function pimpinangcg(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',4)->count();
   return $data;
}

function unit_keyperson(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',1)->get();
   return $data;
}

function pimpinansubdit(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',6)->count();
   return $data;
}

function unit_pimpinansubdit(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',6)->get();
   return $data;
}

function managergcg(){
   $data=App\Hasrole::where('kode',Auth::user()['kode'])->where('role_id',4)->count();
   return $data;
}


?>