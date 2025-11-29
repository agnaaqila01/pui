@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-slate-900">Tambah Jadwal</h3>
                    <p class="mt-1 text-sm text-slate-600">
                        Tambahkan jadwal kegiatan baru.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="hari" class="block text-sm font-medium text-slate-700">Hari</label>
                                    <select id="hari" name="hari" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                    @error('hari') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="kelas" class="block text-sm font-medium text-slate-700">Kelas</label>
                                    <input type="text" name="kelas" id="kelas" value="{{ old('kelas') }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md" placeholder="Contoh: 1A">
                                    @error('kelas') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="kegiatan" class="block text-sm font-medium text-slate-700">Nama Kegiatan</label>
                                    <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan') }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                    @error('kegiatan') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="jam_mulai" class="block text-sm font-medium text-slate-700">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                    @error('jam_mulai') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="jam_selesai" class="block text-sm font-medium text-slate-700">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                    @error('jam_selesai') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-slate-50 text-right sm:px-6">
                            <a href="{{ route('jadwal.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 mr-3 border-slate-300">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
