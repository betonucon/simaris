<?php

namespace App;
use App\Unit;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $table = 'kpi';
    
    public $timestamps = false;
    protected $fillable = [
        'kode','name', 'unit_id', 'tahun','periode_id','creator','tanggal','deleted','level','sts',
    ];
    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id', 'objectabbr');

    }
    public function periode()
    {
        return $this->belongsTo('App\Periode', 'periode_id', 'id');

    }
}
