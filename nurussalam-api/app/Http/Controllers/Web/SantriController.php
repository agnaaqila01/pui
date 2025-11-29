<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    public function index()
    {
        $santris = Santri::latest()->paginate(10);
        return view('santri.index', compact('santris'));
    }

    public function create()
    {
        return view('santri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:santris',
            'nama' => 'required',
            'kelas' => 'required',
            'alamat' => 'nullable',
        ]);

        $santri = new Santri();
        $santri->nis = $request->nis;
        $santri->nama = $request->nama;
        $santri->kelas = $request->kelas;
        $santri->alamat = $request->alamat;
        $santri->password = Hash::make('santri123'); // Default password
        $santri->save();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan');
    }

    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|unique:santris,nis,' . $id,
            'nama' => 'required',
            'kelas' => 'required',
            'alamat' => 'nullable',
        ]);

        $santri = Santri::findOrFail($id);
        $santri->nis = $request->nis;
        $santri->nama = $request->nama;
        $santri->kelas = $request->kelas;
        $santri->alamat = $request->alamat;
        
        if ($request->filled('password')) {
            $santri->password = Hash::make($request->password);
        }

        $santri->save();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui');
    }

    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus');
    }
}
