<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterIndikatorGrup extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['nama', 'keterangan'];

    public function indikatorNilai()
    {
        return $this->hasMany(MasterIndikatorNilai::class, 'indikator_grup_id');
    }
}
