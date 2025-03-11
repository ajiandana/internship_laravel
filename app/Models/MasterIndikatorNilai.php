<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterIndikatorNilai extends Model
{
    use HasFactory;

    protected $fillable = ['indikator_grup_id', 'skor'];

    public function indikatorGrup()
    {
        return $this->belongsTo(MasterIndikatorGrup::class, 'indikator_grup_id');
    }
}
