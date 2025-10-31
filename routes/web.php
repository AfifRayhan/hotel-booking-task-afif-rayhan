<?php

use App\Http\Controllers\BookingController;

Route::get('/', [BookingController::class, 'index'])->name('booking.index');
Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check');
Route::post('/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
Route::get('/thank-you/{id}', [BookingController::class, 'thankYou'])->name('booking.thankyou');

