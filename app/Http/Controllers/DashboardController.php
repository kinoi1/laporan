<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSuratMasuk = Agenda::count();
        $suratTertinggi = Agenda::selectRaw('
        YEAR(created_at) as tahun,
        MONTH(created_at) as bulan,
        COUNT(*) as total
    ')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByDesc('total')
            ->first();
        $suratTerendah = Agenda::selectRaw('
        YEAR(created_at) as tahun,
        MONTH(created_at) as bulan,
        COUNT(*) as total
    ')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderBy('total')
            ->first();

        $rataRataSurat = Agenda::selectRaw('
        COUNT(*) / COUNT(DISTINCT DATE_FORMAT(created_at, "%Y-%m")) as rata_rata
    ')
            ->value('rata_rata');

            return response()->json([
            'success' => true,
            'rata_rata' => $rataRataSurat,
            'tertinggi' => $suratTerendah,
            'terendah'=> $suratTertinggi,
            'total' => $totalSuratMasuk
            ]);
    }
}
