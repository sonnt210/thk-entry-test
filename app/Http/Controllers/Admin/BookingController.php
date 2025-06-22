<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function showSearch(Request $request): View
    {
        $bookings = Booking::query()
            ->with('hotel')
            ->when($request->filled('customer_name'), function ($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
            })
            ->when($request->filled('customer_contact'), function ($query) use ($request) {
                $query->where('customer_contact', 'like', '%' . $request->input('customer_contact') . '%');
            })
            ->when($request->filled('checkin_time'), function ($query) use ($request) {
                $query->whereDate('checkin_time', '>=', $request->input('checkin_time'));
            })
            ->when($request->filled('checkout_time'), function ($query) use ($request) {
                $query->whereDate('checkout_time', '<=', $request->input('checkout_time'));
            })
            ->latest('booking_id')
            ->paginate(20);

        return view('admin.booking.search', [
            'bookings' => $bookings,
            'input' => $request->all(),
        ]);
    }
}
