<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunajaran = TahunAjaran::all();
        return view('admin.pages.tahun-ajaran', [
            'tahunajaran' => $tahunajaran
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Nama tahun ajaran harus diisi'
            ]);

            TahunAjaran::create($request->all());
            return redirect()->back()->with('success', 'Tahun ajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tahun ajaran gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Nama tahun ajaran harus diisi'
            ]);

            $tahunajaran = TahunAjaran::find($id);
            $tahunajaran->update($request->all());
            return redirect()->back()->with('success', 'Tahun ajaran berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tahun ajaran gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            $tahunajaran = TahunAjaran::find($id);
            $tahunajaran->delete();
            return redirect()->back()->with('success', 'Tahun ajaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tahun ajaran gagal dihapus');
        }
    }
}
