<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Pertemuan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\DetailPresensi;
use App\Models\JadwalPelajaran;
use App\Models\DetailJadwalPelajaran;

class DetailPresensiController extends Controller
{
    public function index()
    {
        $tahunajaran = TahunAjaran::all();
        return view('admin.pages.detail-presensi', [
            'tahunajaran' => $tahunajaran
        ]);
    }

    public function getKelasByTahunAjaran(Request $request)
    {
        $kelas = JadwalPelajaran::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->with('kelas')
            ->get()
            ->pluck('kelas')
            ->unique('id');
        return response()->json($kelas);
    }

    public function getPertemuanByKelas(Request $request)
    {
        $pertemuan = Presensi::whereHas('jadwalPelajaran', function ($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })->with('pertemuan')->get()->pluck('pertemuan')->flatten();
        return response()->json($pertemuan);
    }

    public function getHariByPertemuan(Request $request)

    {
        $pertemuan = Pertemuan::where('id', $request->pertemuan_id)->first();
        $presensi = Presensi::where('id', $pertemuan->presensi_id)->first();
        $hari = DetailJadwalPelajaran::where('jadwal_pelajaran_id', $presensi->jadwal_pelajaran_id)
            ->with('hari')
            ->get()
            ->pluck('hari')
            ->unique('id')
            ->values();

        return response()->json($hari);
    }

    public function getMataPelajaranByHari(Request $request)
    {
        $jadwalpelajaran = JadwalPelajaran::where('kelas_id', $request->kelas_id)->first();
        $mataPelajaran = DetailJadwalPelajaran::where('jadwal_pelajaran_id', $jadwalpelajaran->id)
            ->where('hari_id', $request->hari_id)
            ->with('mataPelajaran')
            ->get()
            ->pluck('mataPelajaran')
            ->unique('id');
        return response()->json($mataPelajaran);
    }

    public function getSiswaByFilter(Request $request)
    {
        $pertemuan_id = $request->pertemuan_id;
        $mata_pelajaran_id = $request->mata_pelajaran_id;
        $hari_id = $request->hari_id;
        $kelas_id = $request->kelas_id;
        $presensi_id = Pertemuan::where('id', $pertemuan_id)->first()->presensi_id;

        $siswa = Siswa::where('kelas_id', $kelas_id)
            ->with(['detailPresensi' => function ($query) use ($pertemuan_id, $mata_pelajaran_id, $hari_id, $presensi_id) {
                $query->where('pertemuan_id', $pertemuan_id)
                    ->where('mata_pelajaran_id', $mata_pelajaran_id)
                    ->where('hari_id', $hari_id)
                    ->where('presensi_id', $presensi_id);
            }])
            ->get()
            ->map(function ($siswa) {
                $siswa->status = $siswa->detailPresensi->first()->status ?? '-';
                return $siswa;
            });

        return response()->json($siswa);
    }

    public function updateStatusPresensi(Request $request)
    {
        $siswaId = $request->siswa_id;
        $status = $request->status;
        $mata_pelajaran_id = $request->mata_pelajaran_id;
        $hari_id = $request->hari_id;
        $pertemuan_id = $request->pertemuan_id;
        $presensi_id = Pertemuan::where('id', $pertemuan_id)->first()->presensi_id;

        $detailPresensi = DetailPresensi::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'pertemuan_id' => $pertemuan_id,
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'hari_id' => $hari_id,
                'presensi_id' => $presensi_id,
            ],
            [
                'status' => $status,
            ]

        );

        return response()->json(['message' => 'Status berhasil diperbarui!']);
    }
}
