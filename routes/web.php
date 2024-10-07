<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BookingEmployeeController;


Carbon::setTestNow(now()->addDay()->setTimeFromTimeString('15:30:00'));


Route::get('/', BookingController::class)->name('bookings');

Route::get('/bookings/{employee:slug}', BookingEmployeeController::class)->name('bookings.employee');

Route::get('/checkout/{employee:slug}/{service:slug}', CheckoutController::class)->name('checkout');




