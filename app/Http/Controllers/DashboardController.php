<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // $kegiatan = Kegiatan::all()->count();
        // $konflik = Konflik::all()->count();
        // $gangguan = Gangguan::all()->count();
        // $kriminal = Kriminal::all()->count();
        return view('admin.index');
    }
}
