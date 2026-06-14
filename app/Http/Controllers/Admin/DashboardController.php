<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Facility;
use App\Models\Booking;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalFacilities = Facility::count();
        $totalBookings = Booking::count();
        $totalReviews = Review::count();

        return view('admin.dashboard', compact('totalUsers', 'totalFacilities', 'totalBookings', 'totalReviews'));
    }
}