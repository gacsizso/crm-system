<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ClientController extends Controller
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
        $query = Client::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('type', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%")
                  ->orWhere('notes', 'like', "%$search%")
                ;
            });
        }
        $clients = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('name')->get();
        return view('clients.create', compact('contacts'));
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
            'address' => 'nullable|string|max:255',
            'type' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $validated['added_by'] = auth()->id();
        $validated['added_at'] = now();
        $client = Client::create($validated);
        // Értesítés küldése
        $this->notificationService->notifyClientCreated(auth()->user(), $client);
        return redirect()->route('clients.show', $client)
            ->with('success', 'Ügyfél sikeresen hozzáadva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $contacts = $client->contacts()->orderBy('name')->get();
        $projects = $client->projects()->with('tasks')->orderBy('created_at', 'desc')->get();
        return view('clients.show', compact('client', 'contacts', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $client->update($validated);
        return redirect()->route('clients.index')->with('success', 'Ügyfél sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Ügyfél sikeresen törölve!');
    }
}
