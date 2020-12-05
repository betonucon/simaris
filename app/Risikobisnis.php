<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risikobisnis extends Model
{
    protected $table = 'risikobisnis';
    public $timestamps = false;

    public function kpi()
    {
        return $this->belongsTo('App\Kpi', 'kpi_id', 'id');

    }

    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id', 'objectabbr');

    }
    public function periode()
    {
        return $this->belongsTo('App\Periode', 'periode_id', 'id');

    }
    public function peluang()
    {
        return $this->belongsTo('App\Peluang', 'peluang_id', 'id');

    }
    public function dampak()
    {
        return $this->belongsTo('App\Dampak', 'dampak_id', 'id');

    }
    public function kriteria()
    {
        return $this->belongsTo('App\Kriteria', 'kriteria_id', 'id');

    }
    public function kelompok()
    {
        return $this->belongsTo('App\Kelompok', 'kelompok_id', 'id');

    }
}
