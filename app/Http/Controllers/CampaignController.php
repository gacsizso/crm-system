<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GrahamCampbell\Markdown\Facades\Markdown;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Campaign::with(['groups', 'creator']);
        if ($request->has('group_id')) {
            $query->whereHas('groups', function($q) use ($request) {
                $q->where('groups.id', $request->group_id);
            });
        }
        $campaigns = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::orderBy('name')->get();
        return view('campaigns.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'groups' => 'required|array',
            'groups.*' => 'exists:groups,id',
        ]);
        $campaign = Campaign::create([
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'created_by' => Auth::id(),
        ]);
        $campaign->groups()->sync($validated['groups']);
        return redirect()->route('campaigns.index')->with('success', 'Kampány sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $groups = Group::orderBy('name')->get();
        $selectedGroups = $campaign->groups->pluck('id')->toArray();
        return view('campaigns.edit', compact('campaign', 'groups', 'selectedGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'groups' => 'required|array',
            'groups.*' => 'exists:groups,id',
        ]);
        $campaign->update([
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ]);
        $campaign->groups()->sync($validated['groups']);
        return redirect()->route('campaigns.index')->with('success', 'Kampány sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->groups()->detach();
        $campaign->delete();
        return redirect()->route('campaigns.index')->with('success', 'Kampány sikeresen törölve!');
    }

    public function preview(Campaign $campaign)
    {
        $html = Markdown::convertToHtml($campaign->body);
        return view('campaigns.preview', compact('campaign', 'html'));
    }

    public function send(Request $request, Campaign $campaign)
    {
        if ($campaign->sent) {
            return redirect()->route('campaigns.index')->with('error', 'Ez a kampány már el lett küldve!');
        }
        $recipients = [];
        foreach ($campaign->groups as $group) {
            foreach ($group->clients as $client) {
                if (!empty($client->email)) {
                    $recipients[$client->email] = $client->name;
                }
            }
        }
        $subject = $campaign->subject;
        $bodyHtml = Markdown::convertToHtml($campaign->body);
        foreach ($recipients as $email => $name) {
            Mail::raw(strip_tags($bodyHtml), function($message) use ($email, $subject, $name) {
                $message->to($email, $name)->subject($subject);
            });
        }
        $campaign->sent = true;
        $campaign->sent_at = now();
        $campaign->save();
        return redirect()->route('campaigns.index')->with('success', 'Kampány e-mail(ek) sikeresen elküldve!');
    }
}