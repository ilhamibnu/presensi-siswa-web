<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mata_pelajaran = MataPelajaran::all();
        return view('admin.pages.mata-pelajaran', [
            'matapelajaran' => $mata_pelajaran,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'Nama mata pelajaran tidak boleh kosong',
            ]);

            MataPelajaran::create([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Mata pelajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mata pelajaran gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'Nama mata pelajaran tidak boleh kosong',
            ]);

            MataPelajaran::find($id)->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Mata pelajaran berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mata pelajaran gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            MataPelajaran::find($id)->delete();
            return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mata pelajaran gagal dihapus');
        }
    }
}
