<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'detail_jadwal_pelajaran';

    protected $fillable = [
        'jadwal_pelajaran_id',
        'mata_pelajaran_id',
        'hari_id',
    ];

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class);
    }
}
