<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class SantriController extends Controller
{
    // GET /api/santri
    public function store(Request $request)
{
    $request->validate([
        'nis' => 'required|unique:santris',
        'nama' => 'required',
        'kelas' => 'required',
    ]);

    $santri = new Santri();
    $santri->nis = $request->nis;
    $santri->nama = $request->nama;
    $santri->kelas = $request->kelas;
    $santri->alamat = $request->alamat;
    $santri->password = Hash::make('santri123'); // default password
    $santri->save();

    return response()->json($santri, 201);
}

    // PUT /api/santri/{id}
    public function update(Request $request, $id)
{
    $santri = Santri::findOrFail($id);

    $data = $request->only(['nis', 'nama', 'kelas', 'alamat']);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $santri->update($data);

    return response()->json($santri);
}

    // DELETE /api/santri/{id}
    public function destroy($id)
    {
        Santri::findOrFail($id)->delete();

        return response()->json(['message' => 'Santri dihapus']);
    }
    public function index()
    {
        return response()->json(\App\Models\Santri::all());
    }

    public function import(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.nis' => 'required',
            'data.*.nama' => 'required',
            'data.*.kelas' => 'required',
        ]);

        foreach ($request->data as $row) {
            // Update jika NIS sudah ada, insert jika belum
            Santri::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'nama' => $row['nama'],
                    'kelas' => $row['kelas'],
                    'alamat' => $row['alamat'] ?? '',
                    'password' => isset($row['password']) && $row['password'] ? \Hash::make($row['password']) : \Hash::make('santri123'),
                ]
            );
        }

        return response()->json(['message' => 'Import data santri berhasil']);
    }

    
}
