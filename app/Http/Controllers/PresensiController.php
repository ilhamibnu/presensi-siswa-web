<?php

namespace App\Http\Controllers;

use App\Models\DetailPresensi;
use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Pertemuan;

class PresensiController extends Controller
{
    public function index()
    {
        $presensi = Presensi::with('jadwalPelajaran')->get();
        $jadwalPelajaran = JadwalPelajaran::with('tahunAjaran', 'kelas')->get();
        return view('admin.pages.presensi', [
            'presensi' => $presensi,
            'jadwalPelajaran' => $jadwalPelajaran,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'jadwal_pelajaran_id' => 'required',
                'jumlah_pertemuan' => 'required',
            ], [
                'jadwal_pelajaran_id.required' => 'Jadwal pelajaran wajib diisi',
                'jumlah_pertemuan.required' => 'Jumlah pertemuan wajib diisi',
            ]);

            $presensi = new Presensi();
            $presensi->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
            $presensi->jumlah_pertemuan = $request->jumlah_pertemuan;
            $presensi->save();

            for ($i = 1; $i <= $request->jumlah_pertemuan; $i++) {
                $pertemuan = new Pertemuan();
                $pertemuan->presensi_id = $presensi->id;
                $pertemuan->name = 'Pertemuan ' . $i;
                $pertemuan->save();
            }

            return redirect()->back()->with('success', 'Data presensi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data presensi gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'jadwal_pelajaran_id' => 'required',
                'jumlah_pertemuan' => 'required',
            ], [
                'jadwal_pelajaran_id.required' => 'Jadwal pelajaran wajib diisi',
                'jumlah_pertemuan.required' => 'Jumlah pertemuan wajib diisi',
            ]);

            $presensi = Presensi::find($id);
            $presensi->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
            $presensi->jumlah_pertemuan = $request->jumlah_pertemuan;
            $presensi->save();

            DetailPresensi::where('presensi_id', $id)->delete();
            Pertemuan::where('presensi_id', $id)->delete();

            for ($i = 1; $i <= $request->jumlah_pertemuan; $i++) {
                $pertemuan = new Pertemuan();
                $pertemuan->presensi_id = $presensi->id;
                $pertemuan->name = 'Pertemuan ' . $i;
                $pertemuan->save();
            }
            return redirect()->back()->with('success', 'Data presensi berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data presensi gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            $presensi = Presensi::find($id);
            DetailPresensi::where('presensi_id', $id)->delete();
            Pertemuan::where('presensi_id', $id)->delete();
            $presensi->delete();
            return redirect()->back()->with('success', 'Data presensi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data presensi gagal dihapus');
        }
    }
}
