<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Projects\Models\Project;
use Illuminate\Support\Facades\Gate;

class ProjectAdminController extends Controller
{
    public function index()
    {
        Gate::authorize('admin-only');
        $projects = Project::withCount('members')->with('owner')->get();
        return response()->json($projects);
    }
}
