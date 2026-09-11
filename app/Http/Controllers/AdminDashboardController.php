<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Marriage;
use App\Models\Relationship;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalAnggota = Individual::count();
        $totalLaki = Individual::where('gender', 'male')->count();
        $totalPerempuan = Individual::where('gender', 'female')->count();
        $totalPernikahan = Marriage::count();
        $totalRelasi = Relationship::count();

        return view('admin.dashboard', compact(
            'totalAnggota',
            'totalLaki',
            'totalPerempuan',
            'totalPernikahan',
            'totalRelasi'
        ));
    }
}
