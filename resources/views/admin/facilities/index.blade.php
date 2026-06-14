@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold">Manage Facilities</h2>
<a href="{{ route('admin.facilities.create') }}" class="bg-green-600 text-white px-4 py-2 inline-block my-3">+ Add Facility</a>
<table class="w-full bg-white rounded shadow">
    <thead>
        <tr><th>Name</th><th>Type</th><th>Price</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @foreach($facilities as $facility)
        <tr>
            <td>{{ $facility->name }}</td>
            <td>{{ $facility->sport_type }}</td>
            <td>RM {{ $facility->price_per_hour }}</td>
            <td>
                <a href="{{ route('admin.facilities.edit', $facility) }}" class="text-blue-600">Edit</a>
                <form method="POST" action="{{ route('admin.facilities.destroy', $facility) }}" class="inline" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 ml-2">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection