<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
use Illuminate\View\View;

use Illuminate\Http\Request;

class PasienController extends Controller
{

    public function getAllPasien() {
      $pasien = Pasien::all();
      return response()->json($pasien,200);
    }

    public function getDetailPasien(Request $request) {
      $pasien = Pasien::with('reservations')->find($request->id);
      if (!$pasien) {
        return response()->json(['error' => 'User not found'], 404);
      }
      return response()->json($pasien, 200);
    }

    public function show(string $id): View
    {
      return view('detail_pasien', ['pasien' => Pasien::find($id)]);
    }

    public function showUpdate(string $id): View {
      return view('edit_pasien', ['pasien' => Pasien::find($id)]);
    }

    public function index(): View {
        return view('pasien', ['pasien' => Pasien::all()]);
    }

    public function inputPage(): View {
        return view('input_pasien');
    }

    public function update(Request $request, $id) {
      $validatedData = $request->validate([
        'nama' => 'required',
        'tanggal_lahir' => 'required',
        'nik' => 'required',
        'alamat' => 'required',
        'gender' => 'required|min:1|max:1',
      ]);

      $pasien = Pasien::find($id);
      $pasien->update($validatedData);

      return redirect('/data');
    }

    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'nama' => 'required',
        'tanggal_lahir' => 'required',
        'nik' => 'required',
        'alamat' => 'required',
        'gender' => 'required|min:1|max:1',
      ]);

      Pasien::create($validatedData);
      return redirect('/data');
    }
}
