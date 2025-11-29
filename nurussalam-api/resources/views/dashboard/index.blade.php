@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">Dashboard Overview</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Total Santri -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-slate-100 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-slate-500 truncate">
                                    Total Santri
                                </dt>
                                <dd>
                                    <div class="text-2xl font-bold text-slate-900">
                                        {{ $totalSantri }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('santri.index') }}" class="font-medium text-blue-600 hover:text-blue-500">View all</a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Kehadiran Hari Ini -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-slate-100 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-slate-500 truncate">
                                    Kehadiran Hari Ini
                                </dt>
                                <dd>
                                    <div class="text-2xl font-bold text-slate-900">
                                        {{ $kehadiran }}%
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('absensi.index') }}" class="font-medium text-green-600 hover:text-green-500">View details</a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Pengumuman Aktif -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-slate-100 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-slate-500 truncate">
                                    Pengumuman Aktif
                                </dt>
                                <dd>
                                    <div class="text-2xl font-bold text-slate-900">
                                        {{ $pengumumanAktif }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('pengumuman.index') }}" class="font-medium text-yellow-600 hover:text-yellow-500">Manage</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <h3 class="text-lg leading-6 font-medium text-slate-900 mb-4">Grafik Kehadiran (7 Hari Terakhir)</h3>
                <div class="relative h-64">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Santri Hadir',
                data: {!! json_encode($chartData) !!},
                borderColor: 'rgb(16, 185, 129)', // Green-500
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection
