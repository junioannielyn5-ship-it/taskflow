<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController
{
    public function index(Request $request)
    {
        return view('employee.index');
    }
}
