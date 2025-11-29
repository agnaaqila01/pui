@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Monitoring Absensi</h1>
            
            <form action="{{ route('absensi.index') }}" method="GET" class="flex items-center space-x-2">
                <label for="tanggal" class="text-sm font-medium text-slate-700">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm border-slate-300 rounded-md" onchange="this.form.submit()">
            </form>
        </div>

        <div class="bg-white shadow overflow-hidden border-b border-slate-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Santri</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kegiatan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($absensis as $absensi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $absensi->created_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                            {{ $absensi->santri->nama }}
                            <span class="block text-xs text-slate-500">{{ $absensi->santri->kelas }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $absensi->jadwal->kegiatan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($absensi->status == 'hadir')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                            @elseif($absensi->status == 'izin')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Izin</span>
                            @elseif($absensi->status == 'sakit')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Sakit</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Alpha</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                            Tidak ada data absensi untuk tanggal ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $absensis->appends(['tanggal' => $tanggal])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
