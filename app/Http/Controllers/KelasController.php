<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.pages.kelas', [
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'Nama kelas tidak boleh kosong',
            ]);

            Kelas::create([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Kelas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kelas gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'Nama kelas tidak boleh kosong',
            ]);

            Kelas::find($id)->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Kelas berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kelas gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            Kelas::find($id)->delete();

            return redirect()->back()->with('success', 'Kelas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kelas gagal dihapus');
        }
    }
}
