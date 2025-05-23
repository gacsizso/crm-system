<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Client;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with('clients')->orderBy('name')->paginate(10);
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('groups.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'clients' => 'nullable|array',
            'clients.*' => 'exists:clients,id',
        ]);
        $group = Group::create($validated);
        if (isset($validated['clients'])) {
            $group->clients()->sync($validated['clients']);
        }
        return redirect()->route('groups.index')->with('success', 'Csoport sikeresen hozzáadva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group->load('clients');
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $clients = Client::orderBy('name')->get();
        $group->load('clients');
        return view('groups.edit', compact('group', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'clients' => 'nullable|array',
            'clients.*' => 'exists:clients,id',
        ]);
        $group->update($validated);
        $group->clients()->sync($validated['clients'] ?? []);
        return redirect()->route('groups.index')->with('success', 'Csoport sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->clients()->detach();
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Csoport sikeresen törölve!');
    }
}
