<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

class LeadController
{
    public function index(Request $request)
    {
        return view('lead.index');
    }
}
