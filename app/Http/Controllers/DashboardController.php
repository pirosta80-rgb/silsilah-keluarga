<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Marriage;
use App\Models\Relationship;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Total anggota
        $totalAnggota = Individual::count();

        // Total laki-laki & perempuan
        $totalLaki = Individual::where('gender', 'male')->count();
        $totalPerempuan = Individual::where('gender', 'female')->count();

        // Total pernikahan
        $totalPernikahan = Marriage::count();

        // Total generasi (berdasarkan level dari root)
        $generasi = $this->hitungGenerasi();

        // Anggota terbaru (5 orang terakhir)
        $anggotaTerbaru = Individual::orderBy('created_at', 'desc')->limit(5)->get();

        // Anggota tertua (berdasarkan tanggal lahir)
        $anggotaTertua = Individual::whereNotNull('birth_date')
                                   ->orderBy('birth_date', 'asc')
                                   ->limit(3)
                                   ->get();

        // Anggota termuda (berdasarkan tanggal lahir)
        $anggotaTermuda = Individual::whereNotNull('birth_date')
                                    ->orderBy('birth_date', 'desc')
                                    ->limit(3)
                                    ->get();

        // Total keluarga (root)
        $root = $this->findRoot();

        return view('dashboard.index', compact(
            'totalAnggota',
            'totalLaki',
            'totalPerempuan',
            'totalPernikahan',
            'generasi',
            'anggotaTerbaru',
            'anggotaTertua',
            'anggotaTermuda',
            'root'
        ));
    }

    /**
     * Hitung jumlah generasi
     */
    private function hitungGenerasi()
    {
        $root = $this->findRoot();
        if (!$root) {
            return 0;
        }

        $maxLevel = 0;
        $this->getMaxLevel($root->id, 0, $maxLevel);
        return $maxLevel + 1;
    }

    /**
     * Cari root (orang tertua tanpa orang tua)
     */
    private function findRoot()
    {
        $childIds = Relationship::pluck('child_id')->toArray();
        $individuals = Individual::all();

        foreach ($individuals as $ind) {
            if (!in_array($ind->id, $childIds)) {
                return $ind;
            }
        }

        return $individuals->first();
    }

    /**
     * Get max level recursively
     */
    private function getMaxLevel($individualId, $currentLevel, &$maxLevel)
    {
        if ($currentLevel > $maxLevel) {
            $maxLevel = $currentLevel;
        }

        $children = Relationship::where('father_id', $individualId)
                                ->orWhere('mother_id', $individualId)
                                ->get();

        foreach ($children as $child) {
            $this->getMaxLevel($child->child_id, $currentLevel + 1, $maxLevel);
        }
    }
}
