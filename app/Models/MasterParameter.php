<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterParameter extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'nama_parameter'
    ];
}
