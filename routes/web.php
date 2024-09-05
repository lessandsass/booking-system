<?php

use App\Bookings\ScheduleAvailability;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $availability = (new ScheduleAvailability())
        ->forPeriod();

    // return view('welcome');
});


