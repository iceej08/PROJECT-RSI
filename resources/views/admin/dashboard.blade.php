@extends('layouts.admin')

@section('title', 'Dashboard - Admin UBSC')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Akun UBSC -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Akun UBSC</p>
                <p class="text-3xl font-bold text-[#004a73] mt-2">{{ $totalAkunUbsc }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-[#004a73]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Verifikasi Pending -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Verifikasi Pending</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingVerification }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Memberships -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Aktif Member</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $activeMemberships }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Activities</h3>
    <div class="space-y-4">
        @forelse($recentActivities as $activity)
            <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 {{ $activity['icon_bg'] }} rounded-full flex items-center justify-center mr-4">
                        @if($activity['icon'] == 'user')
                            <svg class="w-5 h-5 {{ $activity['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @elseif($activity['icon'] == 'clock')
                            <svg class="w-5 h-5 {{ $activity['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif($activity['icon'] == 'check-circle')
                            <svg class="w-5 h-5 {{ $activity['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 {{ $activity['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $activity['title'] }}</p>
                        <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                    </div>
                </div>
                <span class="text-sm text-gray-500">{{ $activity['time'] }}</span>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">Belum ada aktivitas</p>
        @endforelse
    </div>
</div>
@endsection
