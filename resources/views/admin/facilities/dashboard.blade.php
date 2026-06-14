@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold">Admin Dashboard</h2>
<div class="grid md:grid-cols-4 gap-4 mt-4">
    <div class="bg-white p-4 rounded shadow">👥 Users: {{ $totalUsers }}</div>
    <div class="bg-white p-4 rounded shadow">🏟️ Facilities: {{ $totalFacilities }}</div>
    <div class="bg-white p-4 rounded shadow">📅 Bookings: {{ $totalBookings }}</div>
    <div class="bg-white p-4 rounded shadow">⭐ Reviews: {{ $totalReviews }}</div>
</div>
<div class="mt-6">
    <a href="{{ route('admin.facilities.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Manage Facilities</a>
</div>
@endsection