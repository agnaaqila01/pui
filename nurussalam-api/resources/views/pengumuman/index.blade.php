@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Pengumuman</h1>
            <a href="{{ route('pengumuman.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Buat Pengumuman
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            @foreach ($pengumumans as $pengumuman)
            <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-slate-200">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-slate-900">
                        {{ $pengumuman->judul }}
                    </h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('pengumuman.edit', $pengumuman->id) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">Edit</a>
                        <form id="delete-form-{{ $pengumuman->id }}" action="{{ route('pengumuman.destroy', $pengumuman->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(event, 'delete-form-{{ $pengumuman->id }}')" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <p class="text-slate-600">
                        {{ $pengumuman->isi }}
                    </p>
                </div>
                <div class="px-4 py-4 sm:px-6">
                    <p class="text-xs text-slate-500">
                        Dibuat pada: {{ $pengumuman->created_at->format('d M Y H:i') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
