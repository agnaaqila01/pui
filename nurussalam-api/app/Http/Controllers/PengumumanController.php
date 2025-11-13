<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        return response()->json(Pengumuman::all());
    }
    public function store(Request $request)
    {
    $request->validate([
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
    ]);

    $pengumuman = new Pengumuman();
    $pengumuman->judul = $request->judul;
    $pengumuman->isi = $request->isi;
    $pengumuman->save();

    return response()->json(['message' => 'Pengumuman berhasil ditambahkan'], 201);
    }
}
