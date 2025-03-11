<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterInstansi extends Model
{
    protected $table = 'master_instansi';
    protected $fillable = [
        'nama_instansi',
    ];
    public $timestamps = false;
}
