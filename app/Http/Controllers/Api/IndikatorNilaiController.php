<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterIndikatorNilai;
use Illuminate\Http\Request;

class IndikatorNilaiController extends Controller
{
    public function index($indikator_grup_id)
    {
        $nilaiIndikator = MasterIndikatorNilai::where('indikator_grup_id', $indikator_grup_id)->get();

        return response()->json($nilaiIndikator);
    }

    public function getNilaiByGrup($grupId)
    {
        $nilai = MasterIndikatorNilai::where('indikator_grup_id', $grupId)->get();
        return response()->json($nilai);
    }
}
