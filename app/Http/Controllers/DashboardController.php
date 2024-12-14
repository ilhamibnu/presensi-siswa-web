<?php

namespace App\Http\Controllers;

use App\Models\Hari;
use App\Models\User;
use App\Models\Presensi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\DetailPresensi;
use App\Models\JadwalPelajaran;
use App\Models\DetailJadwalPelajaran;
use App\Models\Kelas;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun_ajaran = TahunAjaran::all();
        return view('admin.pages.dashboard', [
            'tahun_ajaran' => $tahun_ajaran
        ]);
    }

    public function presentaseKehadiran(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $tahun_ajaran_id = $request->tahun_ajaran_id;

        if ($tahun_ajaran_id != null && $kelas_id == null) {

            // hitung jumlah guru
            $jumlah_guru = User::where('role_id', 2)->count();

            if ($jumlah_guru == 0) {
                $jumlah_guru = '0';
            } else {
                $jumlah_guru = $jumlah_guru;
            }

            // hitung jumlah mata pelajaran
            $jumlah_mata_pelajaran = DetailJadwalPelajaran::with('jadwalPelajaran')
                ->whereHas('jadwalPelajaran', function ($query) use ($tahun_ajaran_id) {
                    $query->where('tahun_ajaran_id', $tahun_ajaran_id);
                })
                ->pluck('mata_pelajaran_id')
                ->unique()
                ->count();

            if ($jumlah_mata_pelajaran == 0) {
                $jumlah_mata_pelajaran = '0';
            } else {
                $jumlah_mata_pelajaran = $jumlah_mata_pelajaran;
            }

            // hitung jumlah siswa
            $jumlah_siswa = JadwalPelajaran::where('tahun_ajaran_id', $tahun_ajaran_id)
                ->with('kelas')
                ->get()
                ->pluck('kelas.siswa')
                ->flatten()
                ->unique()
                ->count();

            if ($jumlah_siswa == 0) {
                $jumlah_siswa = '0';
            } else {
                $jumlah_siswa = $jumlah_siswa;
            }


            // presentase berdasarkan tahun ajaran
            $jadwal_pelajaran = JadwalPelajaran::where('tahun_ajaran_id', $tahun_ajaran_id)->get();
            $total_siswa = 0;
            $hadir = 0;
            $tidak_hadir = 0;
            $izin = 0;
            $sakit = 0;

            foreach ($jadwal_pelajaran as $jp) {
                $presensi = Presensi::where('jadwal_pelajaran_id', $jp->id)->first();
                $detail_presensi = DetailPresensi::where('presensi_id', $presensi->id)->get();

                if (count($detail_presensi) == 0) {
                    continue;
                } else {
                    $total_siswa += count($detail_presensi);

                    foreach ($detail_presensi as $dp) {
                        if ($dp->status == 'Hadir') {
                            $hadir++;
                        } elseif ($dp->status == 'Tidak Hadir') {
                            $tidak_hadir++;
                        } elseif ($dp->status == 'Izin') {
                            $izin++;
                        } elseif ($dp->status == 'Sakit') {
                            $sakit++;
                        }
                    }
                }
            }

            $presentase_hadir = ($hadir / $total_siswa) * 100;
            $presentase_tidak_hadir = ($tidak_hadir / $total_siswa) * 100;
            $presentase_izin = ($izin / $total_siswa) * 100;
            $presentase_sakit = ($sakit / $total_siswa) * 100;


            return response()->json([
                'hadir' => $presentase_hadir,
                'tidak_hadir' => $presentase_tidak_hadir,
                'izin' => $presentase_izin,
                'sakit' => $presentase_sakit,
                'jumlah_guru' => $jumlah_guru,
                'jumlah_mata_pelajaran' => $jumlah_mata_pelajaran,
                'jumlah_siswa' => $jumlah_siswa,
            ]);
        } else {
            // presentase berdasarkan tahun ajaran dan kelas
            $jadwal_pelajaran = JadwalPelajaran::where('kelas_id', $kelas_id)
                ->where('tahun_ajaran_id', $tahun_ajaran_id)
                ->first();

            // hitung jumlah guru
            $jumlah_guru = User::where('role_id', 2)->count();

            if ($jumlah_guru == 0) {
                $jumlah_guru == 0;
            } else {
                $jumlah_guru = $jumlah_guru;
            }

            $jumlah_siswa = Kelas::find($kelas_id)->siswa->count();

            if ($jumlah_siswa == 0) {
                $jumlah_siswa == 0;
            } else {
                $jumlah_siswa = $jumlah_siswa;
            }

            // // hitung jumlah mata pelajaran
            $jumlah_mata_pelajaran = DetailJadwalPelajaran::with('jadwalPelajaran')
                ->whereHas('jadwalPelajaran', function ($query) use ($tahun_ajaran_id, $kelas_id) {
                    $query->where('tahun_ajaran_id', $tahun_ajaran_id)
                        ->where('kelas_id', $kelas_id);
                })
                ->pluck('mata_pelajaran_id')
                ->unique()
                ->count();

            if ($jumlah_mata_pelajaran == 0) {
                $jumlah_mata_pelajaran == 0;
            } else {
                $jumlah_mata_pelajaran = $jumlah_mata_pelajaran;
            }

            $presensi = Presensi::where('jadwal_pelajaran_id', $jadwal_pelajaran->id)->first();

            $detail_presensi = DetailPresensi::where('presensi_id', $presensi->id)->get();

            if (count($detail_presensi) == 0) {
                return response()->json([
                    'hadir' => 0,
                    'tidak_hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'jumlah_guru' => $jumlah_guru,
                    'jumlah_mata_pelajaran' => $jumlah_mata_pelajaran,
                    'jumlah_siswa' => $jumlah_siswa,
                ]);
            } else {
                $total_siswa = count($detail_presensi);
                $hadir = 0;
                $tidak_hadir = 0;
                $izin = 0;
                $sakit = 0;

                foreach ($detail_presensi as $dp) {
                    if ($dp->status == 'Hadir') {
                        $hadir++;
                    } elseif ($dp->status == 'Tidak Hadir') {
                        $tidak_hadir++;
                    } elseif ($dp->status == 'Izin') {
                        $izin++;
                    } elseif ($dp->status == 'Sakit') {
                        $sakit++;
                    }
                }

                $presentase_hadir = ($hadir / $total_siswa) * 100;
                $presentase_tidak_hadir = ($tidak_hadir / $total_siswa) * 100;
                $presentase_izin = ($izin / $total_siswa) * 100;
                $presentase_sakit = ($sakit / $total_siswa) * 100;
            }

            return response()->json([
                'hadir' => $presentase_hadir,
                'tidak_hadir' => $presentase_tidak_hadir,
                'izin' => $presentase_izin,
                'sakit' => $presentase_sakit,
                'jumlah_guru' => $jumlah_guru,
                'jumlah_mata_pelajaran' => $jumlah_mata_pelajaran,
                'jumlah_siswa' => $jumlah_siswa,
            ]);
        }
    }
}
