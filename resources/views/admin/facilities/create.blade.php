@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Add New Facility</h2>
<form method="POST" action="{{ route('admin.facilities.store') }}" class="bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-3"><label>Name</label><input name="name" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Description</label><textarea name="description" class="border p-2 w-full" required></textarea></div>
    <div class="mb-3"><label>Sport Type</label><input name="sport_type" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Location</label><input name="location" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Price per hour</label><input name="price_per_hour" type="number" step="0.01" class="border p-2 w-full" required></div>
    <div class="mb-3"><label>Image URL</label><input name="image" class="border p-2 w-full" placeholder="https://..."></div>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection