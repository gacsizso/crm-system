<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Group;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $query = Project::with('clients');
        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                ;
            });
        }
        $projects = $query->orderBy('created_at', 'desc')->paginate(10);
        $statuses = [
            'árajánlat' => 'Árajánlat',
            'értékesítés' => 'Értékesítés',
            'sikeres' => 'Sikeresen lezárt',
            'sikertelen' => 'Sikertelenül lezárt',
        ];
        return view('projects.index', compact('projects', 'statuses', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $contacts = Contact::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $currencies = ['HUF', 'EUR', 'USD', 'GBP', 'CHF'];
        return view('projects.create', compact('clients', 'contacts', 'groups', 'users', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'hourly_rate' => 'nullable|numeric',
            'hours' => 'nullable|integer',
            'currency' => 'nullable|string|max:10',
            'note' => 'nullable|string',
            'contact_id' => 'nullable|exists:contacts,id',
            'group_id' => 'nullable|exists:groups,id',
            'manager_id' => 'nullable|exists:users,id',
            'clients' => 'nullable|array',
            'clients.*' => 'exists:clients,id',
        ]);
        $validated['created_by'] = auth()->id();
        $project = Project::create($validated);
        if ($request->has('clients')) {
            $project->clients()->sync($validated['clients']);
        }
        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('clients')->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::with('clients')->findOrFail($id);
        $this->authorize('update', $project);
        $clients = Client::orderBy('name')->get();
        $contacts = Contact::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $currencies = ['HUF', 'EUR', 'USD', 'GBP', 'CHF'];
        return view('projects.edit', compact('project', 'clients', 'contacts', 'groups', 'users', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'hourly_rate' => 'nullable|numeric',
            'hours' => 'nullable|integer',
            'currency' => 'nullable|string|max:10',
            'note' => 'nullable|string',
            'contact_id' => 'nullable|exists:contacts,id',
            'group_id' => 'nullable|exists:groups,id',
            'manager_id' => 'nullable|exists:users,id',
            'clients' => 'nullable|array',
            'clients.*' => 'exists:clients,id',
        ]);
        $project->update($validated);
        if ($request->has('clients')) {
            $project->clients()->sync($validated['clients']);
        }
        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen törölve!');
    }

    public function changeStatus(Request $request, Project $project)
    {
        $this->authorize('update', $project); // opcionális, ha van policy
        $status = $request->input('status');
        if (in_array($status, ['árajánlat', 'értékesítés', 'sikeres', 'sikertelen'])) {
            $project->status = $status;
            $project->save();
            return redirect()->route('projects.show', $project)->with('success', 'Projekt státusza frissítve!');
        }
        return redirect()->route('projects.show', $project)->with('error', 'Érvénytelen státusz!');
    }

    public function quote(Project $project)
    {
        $project->load(['clients', 'contact', 'manager']);
        $pdf = Pdf::loadView('projects.quote', compact('project'));
        $filename = str_replace(' ', '_', strtolower($project->name)) . '_arajanlat.pdf';
        return $pdf->download($filename);
    }
}
