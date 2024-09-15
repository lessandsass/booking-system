<?php

// - lists correct employee availability
// - accounts for different daily schedule times
// - does not show availability for schedule exclusions
// - only shows availability from the current time with an hour in advanced

use App\Bookings\ScheduleAvailability;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;

/* #### lists correct employee availability ####*/
it('lists correct employee availability', function () {

    Carbon::setTestNow(Carbon::parse('1st January 2000'));

    $employee = Employee::factory()
                    ->has(Schedule::factory()->state([
                        'starts_at' => now()->startOfDay(),
                        'ends_at' => now()->addYear()->endOfDay(),
                    ]))
                    ->create();

    $service = Service::factory()->create([
        'duration' => 30
    ]);

    $availability = (new ScheduleAvailability($employee, $service))
                        ->forPeriod(now()->startOfDay(), now()->endOfDay());

    expect($availability->current())
        ->startsAt(now()->setTimeFromTimeString('09:00:00'))
        ->toBeTrue()
        ->endsAt(now()->setTimeFromTimeString('16:30:00'))
        ->toBeTrue();

});




