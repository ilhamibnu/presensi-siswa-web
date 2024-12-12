<?php

namespace App\Http\Controllers;

use App\Models\DetailJadwalPelajaran;
use App\Models\Hari;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran;
use App\Models\Presensi;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $tahun_ajaran = TahunAjaran::all();
        $kelas = Kelas::all();
        $matapelajaran = MataPelajaran::all();
        $jadwal_pelajaran = JadwalPelajaran::with('detailJadwalPelajaran', 'kelas', 'tahunAjaran')->get();
        $hari = Hari::all();
        return view('admin.pages.jadwal-pelajaran', [
            'matapelajaran' => $matapelajaran,
            'kelas' => $kelas,
            'tahun_ajaran' => $tahun_ajaran,
            'jadwalpelajaran' => $jadwal_pelajaran,
            'hari' => $hari,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kelas_id' => 'required',
                'tahun_ajaran_id' => 'required',
                'hari_id' => 'required|array|min:1',
                'hari_id.*' => 'required|integer',
                'mata_pelajaran_id' => 'required|array|min:1',
                'mata_pelajaran_id.*' => 'required|array|min:1',
                'mata_pelajaran_id.*.*' => 'required|integer',
            ], [
                'kelas_id.required' => 'Kelas harus diisi',
                'tahun_ajaran_id.required' => 'Tahun Ajaran harus diisi',
                'hari_id.required' => 'Hari harus diisi',
                'hari_id.*.required' => 'Hari harus diisi',
                'mata_pelajaran_id.required' => 'Mata Pelajaran harus diisi',
                'mata_pelajaran_id.*.required' => 'Mata Pelajaran harus diisi',
                'mata_pelajaran_id.*.*.required' => 'Mata Pelajaran harus diisi',
            ]);

            $jadwal_pelajaran = new JadwalPelajaran();
            $jadwal_pelajaran->kelas_id = $request->kelas_id;
            $jadwal_pelajaran->tahun_ajaran_id = $request->tahun_ajaran_id;
            $jadwal_pelajaran->save();

            foreach ($request->hari_id as $hari_id) {
                if (isset($request->mata_pelajaran_id[$hari_id])) {
                    foreach ($request->mata_pelajaran_id[$hari_id] as $mata_pelajaran_id) {
                        $detail_jadwal_pelajaran = new DetailJadwalPelajaran();
                        $detail_jadwal_pelajaran->jadwal_pelajaran_id = $jadwal_pelajaran->id;
                        $detail_jadwal_pelajaran->hari_id = $hari_id;
                        $detail_jadwal_pelajaran->mata_pelajaran_id = $mata_pelajaran_id;
                        $detail_jadwal_pelajaran->save();
                    }
                }
            }

            return redirect()->back()->with('success', 'Jadwal Pelajaran berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Jadwal Pelajaran gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kelas_id' => 'required',
                'tahun_ajaran_id' => 'required',
                'hari_id' => 'required|array|min:1',
                'hari_id.*' => 'required|integer',
                'mata_pelajaran_id' => 'required|array|min:1',
                'mata_pelajaran_id.*' => 'required|array|min:1',
                'mata_pelajaran_id.*.*' => 'required|integer',
            ], [
                'kelas_id.required' => 'Kelas harus diisi',
                'tahun_ajaran_id.required' => 'Tahun Ajaran harus diisi',
                'hari_id.required' => 'Hari harus diisi',
                'hari_id.*.required' => 'Hari harus diisi',
                'mata_pelajaran_id.required' => 'Mata Pelajaran harus diisi',
                'mata_pelajaran_id.*.required' => 'Mata Pelajaran harus diisi',
                'mata_pelajaran_id.*.*.required' => 'Mata Pelajaran harus diisi',
            ]);

            $jadwal_pelajaran = JadwalPelajaran::findOrFail($id);
            $jadwal_pelajaran->kelas_id = $request->kelas_id;
            $jadwal_pelajaran->tahun_ajaran_id = $request->tahun_ajaran_id;
            $jadwal_pelajaran->save();

            DetailJadwalPelajaran::where('jadwal_pelajaran_id', $id)->delete();
            Presensi::where('jadwal_pelajaran_id', $id)->delete();

            foreach ($request->hari_id as $hari_id) {
                if (isset($request->mata_pelajaran_id[$hari_id])) {
                    foreach ($request->mata_pelajaran_id[$hari_id] as $mata_pelajaran_id) {
                        $detail_jadwal_pelajaran = new DetailJadwalPelajaran();
                        $detail_jadwal_pelajaran->jadwal_pelajaran_id = $jadwal_pelajaran->id;
                        $detail_jadwal_pelajaran->hari_id = $hari_id;
                        $detail_jadwal_pelajaran->mata_pelajaran_id = $mata_pelajaran_id;
                        $detail_jadwal_pelajaran->save();
                    }
                }
            }

            return redirect()->back()->with('success', 'Jadwal Pelajaran berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Jadwal Pelajaran gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            $jadwal_pelajaran = JadwalPelajaran::findOrFail($id);
            $jadwal_pelajaran->presensi()->delete();
            $jadwal_pelajaran->detailJadwalPelajaran()->delete();
            $jadwal_pelajaran->delete();
            return redirect()->back()->with('success', 'Jadwal Pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Jadwal Pelajaran gagal dihapus');
        }
    }
}
