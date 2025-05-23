<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedUser', 'creator']);
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        if ($request->has('mine') && auth()->check()) {
            $query->where('assigned_to', auth()->id());
        }
        $tasks = $query->orderBy('due_date')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $selectedProject = $request->project_id;
        return view('tasks.create', compact('projects', 'users', 'selectedProject'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);
        $validated['created_by'] = auth()->id();
        $task = Task::create($validated);

        // Értesítés küldése, ha van hozzárendelt felhasználó
        if ($task->assigned_to) {
            $assignedUser = User::find($task->assigned_to);
            $this->notificationService->notifyTaskAssigned($assignedUser, $task);
        }

        return redirect()->route('tasks.index')->with('success', 'Feladat sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $projects = Project::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        // Ellenőrizzük, hogy változott-e a hozzárendelt felhasználó
        $oldAssignedTo = $task->assigned_to;
        $task->update($validated);

        // Ha változott a hozzárendelt felhasználó, küldünk értesítést
        if ($task->assigned_to && $task->assigned_to !== $oldAssignedTo) {
            $assignedUser = User::find($task->assigned_to);
            $this->notificationService->notifyTaskAssigned($assignedUser, $task);
        }

        return redirect()->route('tasks.index')->with('success', 'Feladat sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Feladat sikeresen törölve!');
    }

    public function changeStatus(Task $task, Request $request)
    {
        $status = $request->input('status');
        if (in_array($status, ['új', 'folyamatban', 'teljesítve'])) {
            $task->status = $status;
            $task->save();
            return redirect()->back()->with('success', 'Feladat státusza frissítve!');
        }
        return redirect()->back()->with('error', 'Érvénytelen státusz!');
    }

    /**
     * Assign task to user
     */
    public function assign(Task $task, Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $task->assigned_to = $validated['user_id'];
        $task->save();

        // Értesítés küldése
        $assignedUser = User::find($validated['user_id']);
        $this->notificationService->notifyTaskAssigned($assignedUser, $task);

        return redirect()->back()->with('success', 'Feladat sikeresen hozzárendelve!');
    }
}
