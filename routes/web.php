<?php

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Bookings\ScheduleAvailability;

// Carbon::setTestNow(now()->setTimeFromTimeString('12:00'));

Route::get('/', function () {

    $employee = Employee::find(1);
    $service = Service::find(1);

    $availability = (new ScheduleAvailability($employee, $service))
        ->forPeriod(
            now()->startOfDay(),
            now()->addMonth()->endOfDay(),
        );

    // return view('welcome');
});


