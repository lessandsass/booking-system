<?php

namespace App\Http\Controllers;

use App\Bookings\Date;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Bookings\ServiceSlotAvailability;

class CheckoutController extends Controller
{

    public function __invoke(Employee $employee, Service $service)
    {
        abort_unless($employee->services->contains($service), 404);

        $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
                        ->forPeriod(
                            now()->startOfDay(),
                            now()->addMonth()->endOfDay()
                        );

        $availableDates = $availability
                            ->hasSlots()
                            ->mapWithKeys(fn (Date $date) => [
                                $date->date->toDateString() => $date->slots->count()
                            ])
                            ->toArray();

        return view('bookings.checkout', [
            'employee' => $employee,
            'service' => $service,
            'firstAvailableDate' => $availability->firstAvailableDate()->date->toDateString(),
            'availableDates' => $availableDates,
        ]);
    }
}
