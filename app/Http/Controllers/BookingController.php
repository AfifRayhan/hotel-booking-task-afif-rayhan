<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomCategory;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingController extends Controller
{
    // Show booking form
    public function index()
    {
        $categories = RoomCategory::all();
        $bookedDates = [];

        $allBookings = Booking::all();
        $dateMap = [];

        foreach ($allBookings as $booking) {
            $period = CarbonPeriod::create($booking->from_date, $booking->to_date) ;
            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $catId = $booking->room_category_id;
                $dateMap[$dateStr][$catId] = ($dateMap[$dateStr][$catId] ?? 0) + 1;
            }
        }

        foreach ($dateMap as $date => $cats) {
            $fullyBooked = true;
            foreach ($categories as $cat) {
                if (!isset($cats[$cat->id]) || $cats[$cat->id] < 3) {
                    $fullyBooked = false;
                    break;
                }
            }
            if ($fullyBooked) {
                $bookedDates[] = $date;
            }
        }

        return view('booking.index', compact('bookedDates'));
    }

    // Check room availability and calculate price
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required','regex:/^01[0-9]{9}$/'],
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after:from_date',
        ]);

        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        $categories = RoomCategory::all();

        $availability = [];

        foreach ($categories as $category) {
            $dates = CarbonPeriod::create($from, $to);
            $maxBooked = 0;

            foreach ($dates as $date) {
                $bookedCount = Booking::where('room_category_id', $category->id)
                    ->whereDate('from_date', '<=', $date)
                    ->whereDate('to_date', '>=', $date)
                    ->count();
                if ($bookedCount > $maxBooked) {
                    $maxBooked = $bookedCount;
                }
            }

            $available = 3 - $maxBooked;

            $basePrice = 0;
            foreach ($dates as $date) {
                $price = $category->base_price;
                if (in_array($date->format('l'), ['Friday','Saturday'])) {
                    $price *= 1.2; // weekend surcharge
                }
                $basePrice += $price;
            }

            $finalPrice = $basePrice;
            if ($dates->count() >= 3) {
                $finalPrice *= 0.9; // 10% discount
            }

            $availability[] = [
                'category' => $category,
                'available' => $available,
                'base_price' => $basePrice,
                'final_price' => $finalPrice,
            ];
        }

        return view('booking.availability', [
            'availability' => $availability,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);
    }

    // Confirm booking
    public function confirm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required','regex:/^01[0-9]{9}$/'],
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after:from_date',
            'room_category_id' => 'required|exists:room_categories,id',
            'base_price' => 'required|numeric',
            'final_price' => 'required|numeric',
        ]);

        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        $categoryId = $request->room_category_id;

        // Check availability per day for this category
        $dates = CarbonPeriod::create($from, $to);
        foreach ($dates as $date) {
            $bookedCount = Booking::where('room_category_id', $categoryId)
                ->whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->count();
            if ($bookedCount >= 3) {
                return back()->withErrors([
                    'availability' => 'Sorry, the selected room category is fully booked on ' . $date->format('Y-m-d')
                ])->withInput();
            }
        }

        $booking = Booking::create($request->only([
            'name','email','phone','from_date','to_date','room_category_id','base_price','final_price'
        ]));

        return redirect()->route('booking.thankyou', $booking->id);
    }

    // Thank You page
    public function thankYou($id)
    {
        $booking = Booking::with('roomCategory')->findOrFail($id);
        return view('booking.thankyou', compact('booking'));
    }
}
