<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hari;
use App\Models\Role;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Pertemuan;
use App\Models\TahunAjaran;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = [
            'Admin',
            'Guru',
        ];

        foreach ($role as $r) {
            Role::create([
                'name' => $r,
            ]);
        }

        $user = [
            [
                'name' => 'Admin',
                'username' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'role_id' => 1,
            ],
            [
                'name' => 'Guru',
                'username' => 'guru@gmail.com',
                'password' => bcrypt('guru'),
                'role_id' => 2,
            ],
        ];

        foreach ($user as $u) {
            User::create($u);
        }

        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
        ];

        foreach ($hari as $h) {
            Hari::create([
                'name' => $h,
            ]);
        }

        $matpel = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA',
            'IPS',
            'PKN',
            'PJOK',
            'Seni Budaya',
            'TIK',
            'Agama',
            'PKWU',
            'Bimbingan Konseling',
        ];

        foreach ($matpel as $m) {
            MataPelajaran::create([
                'name' => $m,
            ]);
        }

        $kelas = [
            'X - A',
            'X - B',
            'X - C',
            'XI - A',
            'XI - B',
            'XI - C',
            'XII - A',
            'XII - B',
            'XII - C',
        ];

        foreach ($kelas as $k) {
            Kelas::create([
                'name' => $k,
            ]);
        }

        // buat 10 siswa untuk setiap kelas
        $kelas = Kelas::all();
        $siswa = [];
        foreach ($kelas as $k) {
            for ($i = 1; $i <= 10; $i++) {
                $siswa[] = [
                    'name' => 'Siswa ' . $i . ' ' . $k->name,
                    'kelas_id' => $k->id,
                ];
            }
        }

        foreach ($siswa as $s) {
            Siswa::create($s);
        }

        $tahunajaran = [
            '2020/2021',
            '2021/2022',
            '2022/2023',
            '2023/2024',
            '2024/2025',
        ];

        foreach ($tahunajaran as $ta) {
            TahunAjaran::create([
                'name' => $ta,
            ]);
        }


        $kelas = Kelas::all();
        $matpel = MataPelajaran::all();
        $hari = Hari::all();
        $tahunajaran = TahunAjaran::where('name', '2024/2025')->get();

        foreach ($kelas as $k) {
            foreach ($tahunajaran as $ta) {
                // Buat jadwal pelajaran untuk setiap kelas dan tahun ajaran
                $jadwalpelajaran = JadwalPelajaran::create([
                    'kelas_id' => $k->id,
                    'tahun_ajaran_id' => $ta->id,
                ]);

                // Array untuk melacak mapel yang sudah dipakai setiap hari
                $usedMatpelPerDay = [];

                foreach ($hari as $h) {
                    $detailjadwalpelajaran = [];

                    // Shuffle mata pelajaran agar distribusi acak setiap hari
                    $shuffledMatpel = $matpel->shuffle();

                    for ($i = 0; $i < 4; $i++) { // 4 mata pelajaran per hari
                        // Ambil mata pelajaran yang belum digunakan di hari tersebut
                        $availableMatpel = $shuffledMatpel->filter(function ($m) use ($usedMatpelPerDay, $h) {
                            return !isset($usedMatpelPerDay[$h->id]) || !in_array($m->id, $usedMatpelPerDay[$h->id]);
                        });

                        if ($availableMatpel->isEmpty()) {
                            // Jika semua mapel sudah dipakai, reset list hari itu
                            $usedMatpelPerDay[$h->id] = [];
                            $availableMatpel = $shuffledMatpel;
                        }

                        // Ambil mata pelajaran pertama yang tersedia
                        $matpelSelected = $availableMatpel->first();

                        $detailjadwalpelajaran[] = [
                            'jadwal_pelajaran_id' => $jadwalpelajaran->id,
                            'mata_pelajaran_id' => $matpelSelected->id,
                            'hari_id' => $h->id,
                        ];

                        // Tandai mapel ini sudah digunakan pada hari tersebut
                        $usedMatpelPerDay[$h->id][] = $matpelSelected->id;
                    }

                    // Masukkan data detail jadwal pelajaran ke database
                    $jadwalpelajaran->detailJadwalPelajaran()->createMany($detailjadwalpelajaran);
                }
            }
        }

        $jadwalpelajaran = JadwalPelajaran::all();

        foreach ($jadwalpelajaran as $jp) {
            // Buat data presensi untuk setiap jadwal pelajaran
            $presensi = Presensi::create([
                'jadwal_pelajaran_id' => $jp->id,
                'jumlah_pertemuan' => 16, // Misalnya, jumlah pertemuan dalam satu semester
            ]);

            // Buat data pertemuan untuk presensi yang baru dibuat
            $pertemuanData = [];
            for ($i = 1; $i <= $presensi->jumlah_pertemuan; $i++) {
                $pertemuanData[] = [
                    'presensi_id' => $presensi->id,
                    'name' => 'Pertemuan ' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert semua data pertemuan sekaligus untuk efisiensi
            Pertemuan::insert($pertemuanData);
        }
    }
}
