<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('booking', [
            'employees' => Employee::get(),
        ]);
    }
}
