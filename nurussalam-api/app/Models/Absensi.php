<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis'; // pastikan sesuai dengan nama tabel di database
    protected $fillable = ['santri_id', 'jadwal_id', 'tanggal', 'status'];

    public function jadwal()
    {
        return $this->belongsTo(\App\Models\Jadwal::class);
    }
}