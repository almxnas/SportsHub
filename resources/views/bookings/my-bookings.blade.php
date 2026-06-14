@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">My Bookings</h2>

@foreach($bookings as $booking)
<div class="bg-white p-4 rounded shadow mb-4 flex justify-between items-center">
    <div>
        <h3 class="text-xl font-bold">{{ $booking->facility->name }}</h3>
        <p>{{ $booking->booking_date }} | {{ $booking->start_time }} - {{ $booking->end_time }}</p>
        <p>Total: RM {{ $booking->total_price }} | Status: {{ ucfirst($booking->status) }}</p>
    </div>
    <div class="space-x-2">
        @if($booking->status === 'confirmed')
            <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="inline">
                @csrf @method('PATCH')
                <button type="submit" style="background-color: #dc2626; color: white; padding: 4px 12px; border-radius: 4px; border: none; cursor: pointer;">Cancel</button>
            </form>
        @endif

        @if(!$booking->review && $booking->status === 'confirmed')
            <form method="POST" action="{{ route('reviews.store', $booking) }}" class="inline">
                @csrf
                <select name="rating" required style="border: 1px solid #ccc; padding: 4px; border-radius: 4px;">
                    <option value="">Rating</option>
                    <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
                </select>
                <input type="text" name="comment" placeholder="Comment" style="border: 1px solid #ccc; padding: 4px; border-radius: 4px;">
                <button type="submit" style="background-color: #2b6e3c; color: white; padding: 4px 12px; border-radius: 4px; border: none; cursor: pointer;">Add Review</button>
            </form>
        @endif
    </div>
</div>
@endforeach
@endsection