<?php

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Bookings\ScheduleAvailability;
use App\Bookings\ServiceSlotAvailability;
use App\Bookings\SlotRangeGenerator;

Carbon::setTestNow(now()->setTimeFromTimeString('12:00'));

Route::get('/', function () {

    $employees = Employee::get();
    $service = Service::find(1);

    $availability = (new ServiceSlotAvailability($employees, $service))
        ->forPeriod(
            now()->startOfDay(),
            now()->addDay()->endOfDay()
        );

        dd($availability);

    // $generator = (new SlotRangeGenerator(
    //                 now()->startOfDay(),
    //                 now()->addDay()->endOfDay())
    //             );

    // dd($generator->generate(30));

    // $employee = Employee::find(1);
    // $service = Service::find(1);

    // $availability = (new ScheduleAvailability($employee, $service))
    //     ->forPeriod(
    //         now()->startOfDay(),
    //         now()->addMonth()->endOfDay(),
    //     );

    // return view('welcome');
});


