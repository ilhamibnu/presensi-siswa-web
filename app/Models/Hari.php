<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    use HasFactory;

    protected $table = 'hari';

    protected $fillable = [
        'name',
    ];

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class);
    }

    public function detailJadwalPelajaran()
    {
        return $this->hasMany(DetailJadwalPelajaran::class);
    }
}
