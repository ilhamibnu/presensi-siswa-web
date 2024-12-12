<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Pertemuan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\DetailPresensi;
use App\Models\JadwalPelajaran;
use App\Models\DetailJadwalPelajaran;
use App\Models\Hari;

class RekapPresensiController extends Controller
{
    public function index()
    {
        $tahunajaran = TahunAjaran::all();
        return view('admin.pages.rekap-presensi', [
            'rekapPresensi_1' => '0',
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

    public function getMataPelajaranByKelas(Request $request)
    {
        $jadwalpelajaran = JadwalPelajaran::where('kelas_id', $request->kelas_id)->first();

        if (!$jadwalpelajaran) {
            return response()->json([]);
        }

        $mataPelajaran = DetailJadwalPelajaran::where('jadwal_pelajaran_id', $jadwalpelajaran->id)
            ->with('mataPelajaran')
            ->get()
            ->pluck('mataPelajaran')
            ->unique('id')
            ->values()
            ->toArray();

        return response()->json($mataPelajaran);
    }

    public function generateRekap(Request $request)
    {
        $tahunajaran = TahunAjaran::all();
        $tahunAjaranId = $request->tahun_ajaran_id;
        $kelasId = $request->kelas_id;
        $mataPelajaranId = $request->mata_pelajaran_id;

        if (!$tahunAjaranId || !$kelasId || !$mataPelajaranId) {
            return view('admin.pages.rekap-presensi', [
                'rekapPresensi_1' => '0',
                'tahunajaran' => $tahunajaran
            ]);
        } else {
            $rekapPresensi_1 = $this->getRekapanByKelasMataPelajaran($tahunAjaranId, $kelasId, $mataPelajaranId);

            return view('admin.pages.rekap-presensi', [
                'rekapPresensi_1' => $rekapPresensi_1,
                'tahunajaran' => $tahunajaran
            ]);
        }
    }

    private function getRekapanByKelasMataPelajaran($tahunAjaranId, $kelasId, $mataPelajaranId)
    {
        $jadwalPelajaran = JadwalPelajaran::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();

        if (!$jadwalPelajaran) {
            return null;
        }

        $presensi = Presensi::where('jadwal_pelajaran_id', $jadwalPelajaran->id)->first();

        if (!$presensi) {
            return null;
        }

        $pertemuan = Pertemuan::where('presensi_id', $presensi->id)->get();
        $siswa = Siswa::where('kelas_id', $kelasId)->get();

        $rekap = $siswa->map(function ($siswa) use ($pertemuan, $mataPelajaranId) {
            $totalPertemuan = $pertemuan->count();
            $kehadiranTotal = 0; // Total bobot kehadiran siswa
            $statusPerPertemuan = [];
            $bobotPerPertemuan = $totalPertemuan > 0 ? (100 / $totalPertemuan) : 0; // Bobot kehadiran per pertemuan

            foreach ($pertemuan as $p) {
                $detailPresensi = DetailPresensi::where('siswa_id', $siswa->id)
                    ->where('pertemuan_id', $p->id)
                    ->where('mata_pelajaran_id', $mataPelajaranId)
                    ->get();

                $statusPerHari = [];
                $jumlahHadir = 0; // Hitung kehadiran per mata pelajaran dalam satu pertemuan

                if ($detailPresensi->isEmpty()) {
                    // Jika tidak ada data absensi, isi dengan '-'
                    $statusPerHari[] = '-';
                } else {
                    foreach ($detailPresensi as $detail) {
                        $status = $detail->status ?? '-';
                        $statusPerHari[] = $status;

                        if (strtolower($status) === 'hadir') {
                            $jumlahHadir++;
                        }
                    }
                }

                // Gabungkan status kehadiran per hari (misal: "Hadir-Tidak Hadir")
                $statusPerPertemuan[] = implode(' - ', $statusPerHari);

                // Hitung bobot kehadiran berdasarkan jumlah hadir
                if (count($statusPerHari) > 0) {
                    $bobotKehadiran = ($jumlahHadir / count($statusPerHari)) * $bobotPerPertemuan;
                    $kehadiranTotal += $bobotKehadiran;
                }
            }

            $presentaseKehadiran = round($kehadiranTotal, 2);

            return [
                'name' => $siswa->name,
                'status_per_pertemuan' => $statusPerPertemuan,
                'presentase_kehadiran' => $presentaseKehadiran,
            ];
        });

        return [
            'pertemuan' => $pertemuan,
            'siswa' => $rekap,
        ];
    }

    public function index2()
    {
        $tahunajaran = TahunAjaran::all();
        return view('admin.pages.rekap-presensi2', [
            'rekapPresensi_2' => [], // Initialize as empty array
            'tahunajaran' => $tahunajaran
        ]);
    }

    public function getRekapanByKelas(Request $request)
    {
        $tahunAjaranId = $request->tahun_ajaran_id;
        $kelasId = $request->kelas_id;

        $jadwalPelajaran = JadwalPelajaran::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();

        if (!$jadwalPelajaran) {
            return response()->json('Data tidak ditemukan', 404);
        }

        $presensi = Presensi::where('jadwal_pelajaran_id', $jadwalPelajaran->id)->first();
        if (!$presensi) {
            return response()->json('Data tidak ditemukan', 404);
        }

        $pertemuan = Pertemuan::where('presensi_id', $presensi->id)->get();
        $siswa = Siswa::where('kelas_id', $kelasId)->get();

        $rekap = $siswa->map(function ($siswa) use ($pertemuan) {
            $totalPertemuan = $pertemuan->count();
            $kehadiran = 0;
            $statusPerPertemuan = [];

            foreach ($pertemuan as $p) {
                $detailPresensi = DetailPresensi::where('siswa_id', $siswa->id)
                    ->where('pertemuan_id', $p->id)
                    ->first();

                $status = $detailPresensi->status ?? '-';
                $statusPerPertemuan[] = $status;

                if (strtolower($status) === 'hadir') {
                    $kehadiran++;
                }
            }

            $presentaseKehadiran = $totalPertemuan > 0 ? round(($kehadiran / $totalPertemuan) * 100, 2) : 0;

            return [
                'name' => $siswa->name,
                'status_per_pertemuan' => $statusPerPertemuan,
                'presentase_kehadiran' => $presentaseKehadiran,
            ];
        });

        return view('admin.pages.rekap-presensi2', [
            'rekapPresensi_2' => $rekap,
            'tahunajaran' => TahunAjaran::all()
        ]);
    }
}
