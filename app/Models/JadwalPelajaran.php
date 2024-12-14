<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'tahun_ajaran_id',
        'kelas_id',
    ];

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function detailJadwalPelajaran()
    {
        return $this->hasMany(DetailJadwalPelajaran::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
