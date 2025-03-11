<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'mentor_id',
        'indikator_grup_id',
        'parameter_id',
        'nilai_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function indikatorGrup()
    {
        return $this->belongsTo(MasterIndikatorGrup::class, 'indikator_grup_id');
    }

    public function parameter()
    {
        return $this->belongsTo(MasterParameter::class, 'parameter_id');
    }

    public function nilai()
    {
        return $this->belongsTo(MasterIndikatorNilai::class, 'nilai_id');
    }
}
