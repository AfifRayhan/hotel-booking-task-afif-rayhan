@extends('layouts.app')

@section('content')
<style>
    /* Full background*/
    body {
        background: url('{{ asset('images/hotel.jpg') }}') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    
</style>
<h2 style="text-align:center; font-size:48px; color:#ebb031; margin-bottom:50px;">Available Rooms</h2>
<div style="max-width: 1200px; margin: 60px auto; background: rgba(255, 255, 255, 0.9); padding: 40px; border-radius: 15px; box-shadow: 0 0 25px rgba(0,0,0,0.2);">
<form action="{{ route('booking.confirm') }}" method="POST">
    @csrf
    <!-- Pass user info to confirmation -->
    <input type="hidden" name="name" value="{{ $name }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="phone" value="{{ $phone }}">
    <input type="hidden" name="from_date" value="{{ $from_date }}">
    <input type="hidden" name="to_date" value="{{ $to_date }}">

    @foreach($availability as $room)
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3>{{ $room['category']->name }}</h3>

            @if($room['available'] > 0)
                <p><strong>Rooms Available:</strong> {{ $room['available'] }}</p>
                <table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Base Price</th>
                            <th>Surcharge</th>
                            <th>Final Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $from = \Carbon\Carbon::parse($from_date);
                            $to = \Carbon\Carbon::parse($to_date);
                            $dates = \Carbon\CarbonPeriod::create($from, $to);
                            $totalBase = 0;
                            $totalFinal = 0;
                        @endphp

                        @foreach($dates as $date)
                            @php
                                $dayName = $date->format('l');
                                $base = $room['category']->base_price;
                                $surcharge = in_array($dayName, ['Friday','Saturday']) ? $base * 0.2 : 0;
                                $final = $base + $surcharge;
                                $totalBase += $base;
                                $totalFinal += $final;
                            @endphp
                            <tr>
                                <td>{{ $date->format('Y-m-d') }}</td>
                                <td>{{ $dayName }}</td>
                                <td>{{ number_format($base,2) }} BDT</td>
                                <td>{{ number_format($surcharge,2) }} BDT</td>
                                <td>{{ number_format($final,2) }} BDT</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @php
                    $discount = ($dates->count() >= 3) ? 0.1 * $totalFinal : 0;
                    $finalPriceWithDiscount = $totalFinal - $discount;
                @endphp

                <p><strong>Total Base Price:</strong> {{ number_format($totalBase,2) }} BDT</p>
                <p><strong>Total Final Price (with weekend surcharge):</strong> {{ number_format($totalFinal,2) }} BDT</p>
                @if($discount > 0)
                    <p><strong>Discount (10% for 3+ nights):</strong> -{{ number_format($discount,2) }} BDT</p>
                @endif
                <p><strong>Final Price:</strong> {{ number_format($finalPriceWithDiscount,2) }} BDT</p>

                <!-- Select this room -->
                <input type="radio" name="room_category_id" value="{{ $room['category']->id }}" required>
                Select this room

                <!-- Pass calculated prices to confirmation -->
                <input type="hidden" name="base_price" value="{{ $totalBase }}">
                <input type="hidden" name="final_price" value="{{ $finalPriceWithDiscount }}">
            @else
                <p style="color:red;"><strong>No rooms available.</strong></p>
            @endif
        </div>
    @endforeach

    <button style="margin-top:40px; padding:25px 60px; font-size:28px; background:#007bff; color:white; border:none; border-radius:15px; cursor:pointer; transition:0.3s; box-shadow:0 10px 10px rgba(0,0,0,0.2);" 
                onmouseover="this.style.background='#0056b3'" 
                onmouseout="this.style.background='#007bff'">
        Confirm Booking
    </button>
</form>
</div>
@endsection
