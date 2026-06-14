@extends('layouts.app')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-3xl font-bold">{{ $facility->name }}</h2>
    <p class="text-gray-600">{{ $facility->sport_type }} | {{ $facility->location }}</p>
    <p class="mt-2">{{ $facility->description }}</p>
    <p class="text-green-700 font-bold text-xl mt-2">RM {{ $facility->price_per_hour }} / hour</p>

    <hr class="my-4">

    <h3 class="text-xl font-bold">📅 Make a Booking</h3>

    <form method="POST" action="/facilities/{{ $facility->id }}/book">
        @csrf
        <div>
            <label>Date</label>
            <input type="date" name="booking_date" required class="border p-2 w-full">
        </div>
        <div class="flex gap-4">
            <div><label>Start time</label><input type="time" name="start_time" required class="border p-2"></div>
            <div><label>End time</label><input type="time" name="end_time" required class="border p-2"></div>
        </div>
        <button type="submit" style="background-color: #2b6e3c; color: white; padding: 8px 16px; border-radius: 4px; font-weight: bold;">Confirm Booking</button>
</div>
@endsection