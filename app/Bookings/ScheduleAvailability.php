<?php

namespace App\Bookings;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use Spatie\Period\Period;
use Spatie\Period\Precision;
use Spatie\Period\Boundaries;
use App\Models\ScheduleExclusion;
use Spatie\Period\PeriodCollection;

class ScheduleAvailability
{

    protected PeriodCollection $periods;

    public function __construct(protected Employee $employee, protected Service $service)
    {
        $this->periods = new PeriodCollection();
    }

    public function forPeriod(Carbon $startsAt, Carbon $endsAt)
    {

        collect(CarbonPeriod::create($startsAt, $endsAt)->days())
            ->each(function ($date) {

                $this->addAvailabilityFromSchedule($date);

                $this->employee->scheduleExclusions->each(function (ScheduleExclusion $exclusion) {
                    $this->subtractScheduleExclusion($exclusion);
                });

            });

        foreach ($this->periods as $period) {
            dump($period->asString());
        }
    }

    protected function subtractScheduleExclusion(ScheduleExclusion $exclusion)
    {
        $this->periods = $this->periods->subtract(
            Period::make(
                $exclusion->starts_at,
                $exclusion->ends_at,
                Precision::MINUTE(),
                Boundaries::EXCLUDE_END(),
            )
        );
    }

    protected function addAvailabilityFromSchedule(Carbon $date)
    {

        if (!$schedule = $this->employee->schedules->where('starts_at', '<=', $date)->where('ends_at', '>=', $date)->first()) {
            return;
        }

        if (![$startsAt, $endsAt] = $schedule->getWorkingHoursFromDate($date)) {
            return;
        }

        $this->periods = $this->periods->add(
            Period::make(
                $date->copy()->setTimeFromTimeString($startsAt),
                $date->copy()->setTimeFromTimeString($endsAt)->subMinutes($this->service->duration),
                Precision::MINUTE()
            )
        );

    }

}



