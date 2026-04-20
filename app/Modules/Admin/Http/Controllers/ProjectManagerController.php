<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

class ProjectManagerController
{
    public function index(Request $request)
    {
        return view('project-manager.index');
    }
}
