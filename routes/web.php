<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPresensiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\RekapPresensiController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::middleware(['IsAdmin'])->group(function () {

        Route::get('/kelas', [KelasController::class, 'index']);
        Route::post('/kelas', [KelasController::class, 'store']);
        Route::put('/kelas/{id}', [KelasController::class, 'update']);
        Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);

        Route::get('/siswa', [SiswaController::class, 'index']);
        Route::post('/siswa', [SiswaController::class, 'store']);
        Route::put('/siswa/{id}', [SiswaController::class, 'update']);
        Route::delete('/siswa/{id}', [SiswaController::class, 'destroy']);

        Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index']);
        Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store']);
        Route::put('/mata-pelajaran/{id}', [MataPelajaranController::class, 'update']);
        Route::delete('/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy']);

        Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index']);
        Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store']);
        Route::put('/tahun-ajaran/{id}', [TahunAjaranController::class, 'update']);
        Route::delete('/tahun-ajaran/{id}', [TahunAjaranController::class, 'destroy']);

        Route::post('/jadwal-pelajaran', [JadwalPelajaranController::class, 'store']);
        Route::put('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'update']);
        Route::delete('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'destroy']);

        Route::get('/guru', [GuruController::class, 'index']);
        Route::post('/guru', [GuruController::class, 'store']);
        Route::put('/guru/{id}', [GuruController::class, 'update']);
        Route::delete('/guru/{id}', [GuruController::class, 'destroy']);
    });


    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index']);


    Route::get('/presensi', [PresensiController::class, 'index']);
    Route::post('/presensi', [PresensiController::class, 'store']);
    Route::put('/presensi/{id}', [PresensiController::class, 'update']);
    Route::delete('/presensi/{id}', [PresensiController::class, 'destroy']);

    Route::get('/detail-presensi', [DetailPresensiController::class, 'index']);
    Route::get('/detail-presensi/get-kelas-by-tahun-ajaran', [DetailPresensiController::class, 'getKelasByTahunAjaran'])->name('getKelasByTahunAjaran');
    Route::get('/detail-presensi/get-pertemuan-by-kelas', [DetailPresensiController::class, 'getPertemuanByKelas'])->name('getPertemuanByKelas');
    Route::get('/detail-presensi/get-hari-by-pertemuan', [DetailPresensiController::class, 'getHariByPertemuan'])->name('getHariByPertemuan');
    Route::get('/detail-presensi/get-mata-pelajaran-by-hari', [DetailPresensiController::class, 'getMataPelajaranByHari'])->name('getMataPelajaranByHari');
    Route::get('/detail-presensi/get-siswa-by-filter', [DetailPresensiController::class, 'getSiswaByFilter'])->name('getSiswaByFilter');
    Route::post('/update-status-presensi', [DetailPresensiController::class, 'updateStatusPresensi'])->name('updateStatusPresensi');

    Route::get('/rekap-presensi', [RekapPresensiController::class, 'index']);
    Route::get('/rekap-presensi/get-kelas-by-tahun-ajaran', [RekapPresensiController::class, 'getKelasByTahunAjaran'])->name('getKelasByTahunAjaran');
    Route::get('/rekap-presensi/get-mata-pelajaran-by-kelas', [RekapPresensiController::class, 'getMataPelajaranByKelas'])->name('getMataPelajaranByKelas');
    Route::post('/rekap-presensi/generate', [RekapPresensiController::class, 'generateRekap'])->name('rekap.presensi.generate');
    Route::get('/rekap-presensi/rekapan-kelas-mapel', [RekapPresensiController::class, 'getRekapanByKelasMataPelajaran'])->name('getRekapanByKelasMataPelajaran');

    Route::get('/rekap-presensi2', [RekapPresensiController::class, 'index2']);
    Route::post('/rekap-kelas', [RekapPresensiController::class, 'getRekapanByKelas'])->name('rekap.kelas');
});
