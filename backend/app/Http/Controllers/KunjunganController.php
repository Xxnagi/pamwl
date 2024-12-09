<?php

namespace App\Http\Controllers;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\View\View;

use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(): View {
        return view('kunjungan', ['pasien' => Pasien::with('reservations')->get()]);
    }
}
