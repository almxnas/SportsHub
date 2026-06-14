<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex space-x-8">
                <a href="{{ route('facilities.index') }}" class="px-3 py-2 text-gray-700">🏟️ Facilities</a>
                @auth
                    <a href="{{ route('my-bookings') }}" class="px-3 py-2 text-gray-700">📅 My Bookings</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-red-600">🔧 Admin Panel</a>
                    @endif
                @endauth
            </div>
            <div>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-2">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>