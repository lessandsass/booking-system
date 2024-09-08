<?php

use App\Bookings\ScheduleAvailability;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $employee = Employee::find(1);
    $service = Service::find(1);

    /*
    # No error was found, here the given peried start from now, it also checking the
    currently date, so the schedule date have to be the current date. if the code not work change or update the schedule to current date.
    # here the code also check the availability from the today's or current date
    */
    $availability = (new ScheduleAvailability($employee, $service))
        ->forPeriod(
            now()->startOfDay(),
            now()->addMonth()->endOfDay(),
        );

    // return view('welcome');
});


