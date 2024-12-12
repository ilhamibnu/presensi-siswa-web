<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'name',
    ];

    public function detailJadwalPelajaran()
    {
        return $this->hasMany(DetailJadwalPelajaran::class);
    }

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class);
    }
}
