<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\Request;

class ClientContactController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            abort(403, 'Nincs jogosultságod megtekinteni ezt az oldalt.');
        }
        $clients = Client::with('contacts')->orderBy('name')->get();
        $contacts = Contact::orderBy('name')->get();
        return view('client_contacts.index', compact('clients', 'contacts'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            abort(403, 'Nincs jogosultságod módosítani az ügyfél-kapcsolattartókat.');
        }
        $contacts = $request->input('contacts', []);
        foreach ($contacts as $clientId => $contactIds) {
            $client = Client::find($clientId);
            if ($client) {
                $ids = array_filter((array)$contactIds);
                $client->contacts()->sync($ids);
            }
        }
        return redirect()->route('client-contacts.index')->with('success', 'Kapcsolattartók sikeresen frissítve!');
    }

    // További metódusok: hozzárendelés, leválasztás, stb. később
} 