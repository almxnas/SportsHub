@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">All Sports Facilities</h2>

<form method="GET" class="mb-6 flex gap-4">
    <input type="text" name="sport_type" placeholder="Sport type (Futsal, Badminton...)" value="{{ request('sport_type') }}" class="border p-2 rounded">
    <input type="text" name="location" placeholder="Location" value="{{ request('location') }}" class="border p-2 rounded">
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Filter</button>
</form>

<div class="grid md:grid-cols-3 gap-6">
    @foreach($facilities as $facility)
    <div class="bg-white rounded shadow p-4">
        <img src="{{ $facility->image }}" class="w-full h-40 object-cover rounded">
        <h3 class="text-xl font-bold mt-2">{{ $facility->name }}</h3>
        <p class="text-gray-600">{{ $facility->sport_type }} • {{ $facility->location }}</p>
        <p class="font-semibold">RM {{ $facility->price_per_hour }}/hour</p>
        <p>⭐ {{ number_format($facility->avgRating(), 1) }} ({{ $facility->reviews->count() }} reviews)</p>
        <a href="{{ route('facilities.show', $facility) }}" style="display: inline-block; margin-top: 8px; background-color: #2563eb; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none;">View & Book</a>    </div>
    @endforeach
</div>
@endsection