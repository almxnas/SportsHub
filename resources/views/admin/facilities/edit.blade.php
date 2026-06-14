@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Facility</h2>
<form method="POST" action="{{ route('admin.facilities.update', $facility) }}" class="bg-white p-6 rounded shadow">
    @csrf @method('PUT')
    <div class="mb-3"><label>Name</label><input name="name" value="{{ $facility->name }}" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Description</label><textarea name="description" class="border p-2 w-full" required>{{ $facility->description }}</textarea></div>
    <div class="mb-3"><label>Sport Type</label><input name="sport_type" value="{{ $facility->sport_type }}" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Location</label><input name="location" value="{{ $facility->location }}" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Price per hour</label><input name="price_per_hour" type="number" step="0.01" value="{{ $facility->price_per_hour }}" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Image URL</label><input name="image" value="{{ $facility->image }}" class="border p-2 w-full"></div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection