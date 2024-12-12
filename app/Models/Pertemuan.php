<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'pertemuan';

    protected $fillable = [
        'presensi_id',
        'name',
    ];

    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class);
    }
}
