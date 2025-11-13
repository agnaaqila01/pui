<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    // Jika nama tabel sudah benar (pengumuman), baris ini boleh dihapus
    protected $table = 'pengumuman';

    // Jika ingin mass assignment
    protected $fillable = ['judul', 'isi'];
}