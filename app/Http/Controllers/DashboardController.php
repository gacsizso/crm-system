<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $myTasks = Task::where('assigned_to', $user->id)->count();
        $myQuoteProjects = Project::whereHas('clients', function($q) use ($user) {
            $q->where('clients.id', $user->id);
        })->where('status', 'árajánlat')->count();
        $mySalesProjects = Project::whereHas('clients', function($q) use ($user) {
            $q->where('clients.id', $user->id);
        })->where('status', 'értékesítés')->count();
        $mySuccessProjects = Project::whereHas('clients', function($q) use ($user) {
            $q->where('clients.id', $user->id);
        })->where('status', 'sikeres')->count();
        $clientsCount = Client::count();
        $usersCount = User::count();
        return view('dashboard', compact('myTasks', 'myQuoteProjects', 'mySalesProjects', 'mySuccessProjects', 'clientsCount', 'usersCount'));
    }
} 