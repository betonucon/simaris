<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return "Cache is cleared";
});




Route::group(['middleware'    => 'auth'],function(){
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
});
Route::group(['middleware'    => 'auth'],function(){
    Route::get('kpi', 'KpiController@index');
    Route::get('kpi/keyperson', 'KpiController@index_keyperson');
    Route::get('kpi/pimpinanunit', 'KpiController@index_pimpinanunit');
    Route::get('kpi/cari_unit', 'KpiController@cari_unit');
    Route::get('kpi/cetak/{id}', 'KpiController@cetak');
    Route::get('kpi/ubah/{id}', 'KpiController@ubah');
    Route::get('kpi/ubah_sts/{id}', 'KpiController@ubah_sts');
    Route::get('kpi/cek/{id}', 'KpiController@cek');
    Route::get('kpi/uncek/{id}', 'KpiController@uncek');
    Route::get('kpi/kirim_email/{id}', 'KpiController@kirim_email');
    Route::get('kpi/hapus/{id}', 'KpiController@hapus');
    Route::get('kpi/view_data', 'KpiController@view_data');
    Route::get('kpi/view_data_user', 'KpiController@view_data_user');
    Route::get('kpi/view_data_pimpinanunit', 'KpiController@view_data_pimpinanunit');
    Route::post('kpi/simpan', 'KpiController@simpan');
    Route::post('kpi/ubah_data/', 'KpiController@ubah_data');
    Route::post('kpi/ubah_data_sts/', 'KpiController@ubah_data_sts');
    Route::post('kpi/import/', 'KpiController@import_data');

});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('periode', 'PeriodeController@index');
    Route::get('periode/cari_unit', 'PeriodeController@cari_unit');
    Route::get('periode/cetak/{id}', 'PeriodeController@cetak');
    Route::get('periode/ubah/{id}', 'PeriodeController@ubah');
    Route::get('periode/cek/{id}', 'PeriodeController@cek_data');
    Route::get('periode/uncek/{id}', 'PeriodeController@uncek');
    Route::get('periode/kirim_email/{id}', 'PeriodeController@kirim_email');
    Route::get('periode/hapus/{id}', 'PeriodeController@hapus');
    Route::get('periode/view_data', 'PeriodeController@view_data');
    Route::post('periode/simpan', 'PeriodeController@simpan');
    Route::post('periode/ubah_data', 'PeriodeController@ubah_data');
    Route::post('periode/import', 'PeriodeController@import_data');

});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('risiko', 'RisikobisnisController@index');
    Route::get('risiko/verifikatur', 'RisikobisnisController@index_verifikatur');
    Route::get('risiko/cari_unit', 'RisikobisnisController@cari_unit');
    Route::get('risiko/view_dampak', 'RisikobisnisController@view_dampak');
    Route::get('risiko/view_dampak_edit', 'RisikobisnisController@view_dampak_edit');
    Route::get('risiko/cetak/{id}', 'RisikobisnisController@cetak');
    Route::get('risiko/ubah/{id}', 'RisikobisnisController@ubah');
    Route::get('risiko/ubah_sts/{id}', 'RisikobisnisController@ubah_sts');
    Route::get('risiko/sumber/{id}', 'RisikobisnisController@sumber');
    Route::get('risiko/sumber_verifikatur/{id}', 'RisikobisnisController@sumber_verifikatur');
    Route::get('risiko/cek/{id}', 'RisikobisnisController@cek_data');
    Route::get('risiko/uncek/{id}', 'RisikobisnisController@uncek');
    Route::get('risiko/kirim_email/{id}', 'RisikobisnisController@kirim_email');
    Route::get('risiko/hapus/{id}', 'RisikobisnisController@hapus');
    Route::get('risiko/view_data', 'RisikobisnisController@view_data');
    Route::get('risiko/view_data_verifikatur', 'RisikobisnisController@view_data_verifikatur');
    Route::post('risiko/simpan', 'RisikobisnisController@simpan');
    Route::post('risiko/ubah_data', 'RisikobisnisController@ubah_data');
    Route::post('risiko/ubah_data_risiko', 'RisikobisnisController@ubah_data_risiko');
    Route::post('risiko/ubah_kaidah', 'RisikobisnisController@ubah_kaidah');
    Route::post('risiko/ubah_kelompok', 'RisikobisnisController@ubah_kelompok');
    Route::post('risiko/ubah_validasi', 'RisikobisnisController@ubah_validasi');
    Route::post('risiko/import', 'RisikobisnisController@import_data');

});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('laporan_risiko', 'LaporanrisikoController@index');
    Route::get('laporan_risiko/user', 'LaporanrisikoController@index_user');
    Route::get('excel_laporan_risiko', 'LaporanrisikoController@laporan_risiko');
    Route::get('laporan_risiko/verifikatur', 'LaporanrisikoController@index_verifikatur');
    Route::get('laporan_risiko/view_data', 'LaporanrisikoController@view_data');
    Route::get('laporan_risiko/view_data_verifikatur', 'LaporanrisikoController@view_data_verifikatur');
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('admin', 'AdminController@index');
    Route::get('admin/cari_nik', 'AdminController@cari_nik');
    Route::get('admin/cetak/{id}', 'AdminController@cetak');
    Route::get('admin/ubah/{id}', 'AdminController@ubah');
    Route::get('admin/hapus/{id}', 'AdminController@hapus');
    Route::get('admin/view_data', 'AdminController@view_data');
    Route::post('admin/simpan', 'AdminController@simpan');
    Route::post('admin/ubah_data', 'AdminController@ubah_data');
    Route::post('admin/import', 'AdminController@import_data');

});




Auth::routes();


