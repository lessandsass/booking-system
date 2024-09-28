<?php

/*
    3. excludes booked appointments for the employee
    4. ignores cancelled appointments
    5. shows multiple employees available for service
*/

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Schedule;
use App\Bookings\ServiceSlotAvailability;

it('shows available time slots for a service', function () {
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

    $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
                    ->forPeriod(now()->startOfDay(), now()->endOfDay());

    expect($availability->first()->date->toDateString())->toEqual(now()->toDateString());

    expect($availability->first()->slots)->toHaveCount(16);

});

it('lists multiple slots over more than one day', function () {
    Carbon::setTestNow(Carbon::parse('1st January 2000'));

    $employee = Employee::factory()
                    ->has(Schedule::factory()->state([
                        'starts_at' => now()->startOfDay(),
                        'ends_at' => now()->endOfYear(),
                    ]))
                    ->create();

    $service = Service::factory()->create([
        'duration' => 30
    ]);

    $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
                    ->forPeriod(now()->startOfDay(), now()->addDay()->endOfDay());

    expect($availability->map(fn ($date) => $date->date->toDateString()))
                    ->toContain(
                        now()->toDateString(),
                        now()->addDay()->toDateString()
                    );

    expect($availability->first()->slots)->toHaveCount(16);

});

