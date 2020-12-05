<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periode';
    public $timestamps = false;
    protected $fillable = [
        'sts_aktif',
    ];
}
