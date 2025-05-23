<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Client;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::with('clients');
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('position', 'like', "%$search%")
                  ->orWhere('notes', 'like', "%$search%")
                ;
            });
        }
        $contacts = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::all();
        $selectedClientId = $request->input('client_id');
        return view('contacts.create', compact('clients', 'selectedClientId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $user = auth()->user();
        if ($user->hasRole(['admin', 'manager']) && $request->filled('user_id')) {
            $validated['user_id'] = $request->input('user_id');
        } else {
            $validated['user_id'] = $user->id;
        }
        Contact::create($validated);
        return redirect()->route('contacts.index')->with('success', 'Kapcsolattartó sikeresen hozzáadva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load('clients');
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);
        $clients = \App\Models\Client::orderBy('name')->get();
        return view('contacts.edit', compact('contact', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $user = auth()->user();
        if ($user->hasRole(['admin', 'manager']) && $request->filled('user_id')) {
            $validated['user_id'] = $request->input('user_id');
        } else {
            $validated['user_id'] = $user->id;
        }
        $contact->update($validated);
        $contact->clients()->sync($request->input('clients', []));
        return redirect()->route('contacts.index')->with('success', 'Kapcsolattartó sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Kapcsolattartó sikeresen törölve!');
    }
}
