<?php

namespace App\Bookings;

use Carbon\Carbon;
use App\Models\Employee;

class Slot
{
    public $employees = [];

    public function __construct(public Carbon $time)
    {
        //
    }

    public function addEmployee(Employee $employee)
    {
        $this->employees[] = $employee;
    }

    public function hasEmployees()
    {
        return !empty($this->employees);
    }

}


