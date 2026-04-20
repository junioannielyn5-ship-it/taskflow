<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MainTaskController extends Controller
{
    public function kanban()
    {
        // Placeholder: You can update this to fetch real Kanban data later
        return Inertia::render('Admin/Tasks/Kanban', [
            'message' => 'Kanban board loaded successfully!'
        ]);
    }
}
