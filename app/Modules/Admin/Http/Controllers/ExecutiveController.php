<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

class ExecutiveController
{
    public function index(Request $request)
    {
        return view('executive.index');
    }
}
