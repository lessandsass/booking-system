<?php

namespace App\Bookings;

use Carbon\Carbon;
use App\Bookings\Date;
use App\Models\Service;
use App\Models\Employee;
use Spatie\Period\Period;
use App\Models\Appointment;
use Spatie\Period\Precision;
use Spatie\Period\Boundaries;
use Illuminate\Support\Collection;
use Spatie\Period\PeriodCollection;

class ServiceSlotAvailability
{

    public function __construct(protected Collection $employees, protected Service $service)
    {

    }

    public function forPeriod(Carbon $startsAt, Carbon $endsAt)
    {
        $range = (new SlotRangeGenerator($startsAt, $endsAt))->generate($this->service->duration);

        $this->employees->each(function (Employee $employee) use ($startsAt, $endsAt, &$range) {

            // get the availability for the employee
            $periods = (new ScheduleAvailability($employee, $this->service))
                            ->forPeriod($startsAt, $endsAt);

            foreach ($periods as $period) {
                $this->addAvailableEmployeeForPeriod($range, $period, $employee);
            }
            // remove the appointment form the period collection
            $periods = $this->removeAppointments($periods, $employee);

            $range = $this->removeEmptySlots($range);

            // add the available employees to the $range
            // remove empty slots
        });

        return $range;

    }

    protected function removeAppointments(PeriodCollection $period, Employee $employee)
    {
        $employee->appointments
            ->whereNull('cancelled_at')->each(function (Appointment $appointment) use (&$period) {
                $period = $period->subtract(
                    Period::make(
                        $appointment->starts_at->copy()->subMinutes($this->service->duration)->addMinute(),
                        $appointment->ends_at,
                        Precision::MINUTE(),
                        Boundaries::EXCLUDE_ALL(),
                    )
                );
            });
    }

    protected function removeEmptySlots(Collection $range)
    {
        return $range
            ->filter(function (Date $date) {
                $date->slots = $date->slots->filter(function (Slot $slot) {
                    return $slot->hasEmployees();
                });

                return true;

            });
    }

    protected function addAvailableEmployeeForPeriod(Collection $range, Period $period, Employee $employee)
    {
        $range->each(function (Date $date) use ($period, $employee) {
            $date->slots->each(function (Slot $slot) use ($period, $employee) {
                // period contains slot time
                if ($period->contains($slot->time)) {
                    $slot->addEmployee($employee);
                }
            });
        });
    }

}




