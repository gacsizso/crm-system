<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'clients' => Client::count(),
            'projects' => Project::count(),
            'tasks' => Task::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
} 