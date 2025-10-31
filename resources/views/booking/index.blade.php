@extends('layouts.app')

@section('title', 'Hotel Booking')

@section('content')
<style>
    /* Full background*/
    body {
        background: url('{{ asset('images/hotel.jpg') }}') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    
</style>

<div style="max-width: 1200px; margin: 60px auto; background: rgba(255, 255, 255, 0.9); padding: 40px; border-radius: 15px; box-shadow: 0 0 25px rgba(0,0,0,0.2);">
    
    <!-- Hotel Image -->
    <div style="text-align:center; margin-bottom:40px;">
        <img src="{{ asset('images/hotel1.jpg') }}" alt="Hotel" style="width:40%; height:400px; object-fit:cover; border-radius:15px;">
    </div>

    <!-- Title -->
    <h2 style="text-align:center; font-size:48px; color:#ebb031; margin-bottom:10px;">Welcome to <strong>The Grand Budapest Hotel</strong></h2>
    
        <p style="text-align:center; font-size:30px; margin-bottom:50px; font-weight:400;">
            Book Your Adventure!
        </p>

    <!-- Form Layout -->
    <form action="{{ route('booking.check') }}" method="POST" style="display:grid; grid-template-columns: 1fr 1fr; gap:50px; font-size:24px;">
        @csrf

        <!-- Left Column -->
        <div style="display:flex; flex-direction:column; gap:25px;">
            <input type="text" name="name" placeholder="Full Name"
                style="padding:25px; font-size:24px; border:2px solid #ccc; border-radius:10px;" required>

            <input type="email" name="email" placeholder="Email"
                style="padding:25px; font-size:24px; border:2px solid #ccc; border-radius:10px;" required>

            <input type="text" name="phone" placeholder="Phone (e.g., 01XXXXXXXXX)"
                style="padding:25px; font-size:24px; border:2px solid #ccc; border-radius:10px;" required>
        </div>

        <!-- Right Column -->
        <div style="display:flex; flex-direction:column; gap:25px;">
            <input type="text" id="from_date" name="from_date" placeholder="From Date"
                style="padding:25px; font-size:24px; border:2px solid #ccc; border-radius:10px;" required>

            <input type="text" id="to_date" name="to_date" placeholder="To Date"
                style="padding:25px; font-size:24px; border:2px solid #ccc; border-radius:10px;" required>

            <button type="submit"
                style="padding:25px; font-size:28px; background:#007bff; color:white; border:none; border-radius:10px; cursor:pointer; transition:0.3s; box-shadow:0 10px 10px rgba(0,0,0,0.2);"
                onmouseover="this.style.background='#0056b3'"
                onmouseout="this.style.background='#007bff'">
                Check Availability
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')


<script>
    const bookedDates = @json($bookedDates ?? []);

    const highlightWeekends = (dayElem, date) => {
        if (date.getDay() === 5 || date.getDay() === 6) {
            dayElem.style.backgroundColor = "#fff3cd";
            dayElem.style.borderRadius = "6px";
        }
    };

    const getNextBookedDate = (fromDate) => {
        const next = bookedDates.find(d => new Date(d) > new Date(fromDate));
        return next ? new Date(next) : null;
    };

    const toPicker = flatpickr("#to_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: bookedDates,
        onDayCreate: (dObj, dStr, fp, dayElem) => highlightWeekends(dayElem, dayElem.dateObj)
    });

    flatpickr("#from_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: bookedDates,
        onChange: function(selectedDates, dateStr) {
            if (!selectedDates.length) return;

            const nextBooked = getNextBookedDate(dateStr);
            toPicker.set('minDate', dateStr);
            toPicker.set('maxDate', nextBooked ? new Date(nextBooked.getTime() - 86400000) : null);
        },
        onDayCreate: (dObj, dStr, fp, dayElem) => highlightWeekends(dayElem, dayElem.dateObj)
    });
</script>
@endsection
