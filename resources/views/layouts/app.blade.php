<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Hotel Booking')</title>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        h2, h3 { margin: 10px 0; }
        .room-card { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background: #fff; }
        button { padding: 8px 16px; margin-top: 10px; }
    </style>
</head>
<body>

@yield('content')

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@yield('scripts')

</body>
</html>
