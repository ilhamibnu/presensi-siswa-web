<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'jadwal_pelajaran_id',
        'jumlah_pertemuan',
    ];

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class);
    }

    public function pertemuan()
    {
        return $this->hasMany(Pertemuan::class);
    }
}
