@extends('layouts.app')

@section('title', 'Booking Confirmed')

@section('content')
<style>
    /* Full background*/
    body {
        background: url('{{ asset('images/hotel.jpg') }}') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    
</style>
<div style="max-width:1200px; margin:60px auto; background:rgba(255,255,255,0.9); padding:40px; border-radius:15px; box-shadow:0 0 25px rgba(0,0,0,0.2); display:grid; grid-template-columns:1fr 1fr; gap:50px; font-family:Arial, sans-serif; font-size:24px;">

    <!-- Left Column: Booking Details -->
    <div style="padding:40px; background:#ffffffd9; border-radius:15px; box-shadow:inset 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="font-size:48px; color:#ebb031; margin-bottom:30px;">Thank You, {{ $booking->name }}!</h2>

        <p><strong>Email:</strong> {{ $booking->email }}</p>
        <p><strong>Phone:</strong> {{ $booking->phone }}</p>
        <p><strong>Room Category:</strong> {{ $booking->roomCategory->name }}</p>
        <p><strong>From:</strong> {{ $booking->from_date }} | <strong>To:</strong> {{ $booking->to_date }}</p>
        <p><strong>Base Price:</strong> {{ number_format($booking->base_price,2) }} BDT</p>
        <p><strong>Final Price (after surcharge/discount):</strong> {{ number_format($booking->final_price,2) }} BDT</p>
        <p style="color:green; font-weight:bold; font-size:28px; margin-top:20px;">Your booking is confirmed!</p>
    </div>

    <!-- Right Column: Next Steps -->
    <div style="padding:40px; background:#f8f9fa; border-radius:15px; box-shadow:inset 0 0 10px rgba(0,0,0,0.05);">
        <h3 style="font-size:36px; margin-bottom:20px;">Next Steps:</h3>
        <ul style="list-style-type:disc; padding-left:20px; font-size:26px; line-height:2;">
            <li>Please keep your booking details for reference.</li>
            <li>Contact us if you need to modify or cancel your booking.</li>
            <ul style="list-style-type:circle; padding-left:40px; margin-top:10px; font-size:24px;">
                <li><strong>Hotel Name:</strong>The Grand Budapest Hotel</li>
                <li><strong>Address:</strong> 99 Republic Square, Zubrowka, Budapest, Hungary</li>
                <li><strong>Phone:</strong> +880 1234-567890</li>
                <li><strong>Email:</strong> info@thegrandbudapest.com</li>
            </ul>
        </ul>

        <a href="{{ route('booking.index') }}">
            <button style="margin-top:40px; padding:25px 60px; font-size:28px; background:#007bff; color:white; border:none; border-radius:15px; cursor:pointer; transition:0.3s; box-shadow:0 10px 10px rgba(0,0,0,0.2);" 
                onmouseover="this.style.background='#0056b3'" 
                onmouseout="this.style.background='#007bff'">
                Book Another Room
            </button>
        </a>
    </div>

</div>

@endsection
