<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hasrole extends Model
{
    protected $table = 'has_role';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'kode', 'kode');

    }
    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id', 'objectabbr');

    }
    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');

    }
}
