<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $siswa = Siswa::with('kelas')->get();
        return view('admin.pages.siswa', [
            'siswa' => $siswa,
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',

                'kelas_id' => 'required',
            ], [
                'name.required' => 'Nama siswa tidak boleh kosong',

                'kelas_id.required' => 'Kelas siswa tidak boleh kosong',
            ]);

            Siswa::create([
                'name' => $request->name,

                'kelas_id' => $request->kelas_id,
            ]);

            return redirect()->back()->with('success', 'Siswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Siswa gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',

                'kelas_id' => 'required',
            ], [
                'name.required' => 'Nama siswa tidak boleh kosong',

                'kelas_id.required' => 'Kelas siswa tidak boleh kosong',
            ]);

            Siswa::find($id)->update([
                'name' => $request->name,

                'kelas_id' => $request->kelas_id,
            ]);

            return redirect()->back()->with('success', 'Siswa berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Siswa gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            Siswa::find($id)->delete();

            return redirect()->back()->with('success', 'Siswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Siswa gagal dihapus');
        }
    }
}
