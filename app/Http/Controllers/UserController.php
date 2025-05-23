<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('role', 'like', "%$search%")
                ;
            });
        }
        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = ['manager' => 'Menedzser', 'user' => 'Felhasználó', 'employee' => 'Alkalmazott', 'staff' => 'Személyzet'];
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => 'nullable|image|max:2048',
        ]);
        $data = $validated;
        $data['password'] = Hash::make($validated['password']);
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }
        User::create($data);
        return redirect()->route('users.index')->with('success', 'Alkalmazott sikeresen hozzáadva!');
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
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'language' => ['required', 'string', 'in:hu,en'],
            'theme' => ['required', 'string', 'in:light,dark'],
            'profile_image' => ['nullable', 'image', 'max:1024']
        ]);
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
        }
        $user->update($validated);
        return redirect()->route('users.edit', $user)->with('success', 'Profil sikeresen frissítve.');
    }

    public function password()
    {
        return view('users.password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('users.password')
            ->with('success', 'Jelszó sikeresen módosítva.');
    }

    public function settings()
    {
        return view('users.settings');
    }

    public function updateSettings(Request $request)
    {
        $settings = $request->input('settings', []);
        
        // Convert checkbox values to boolean
        $settings = array_map(function($value) {
            return $value === '1';
        }, $settings);

        auth()->user()->update([
            'settings' => $settings
        ]);

        return redirect()->route('users.settings')
            ->with('success', 'Beállítások sikeresen mentve.');
    }

    public function updateTheme(Request $request)
    {
        $request->validate(['theme' => 'required|in:light,dark']);
        $user = auth()->user();
        $user->theme = $request->theme;
        $user->save();
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->profile_image) {
            Storage::delete($user->profile_image);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Felhasználó sikeresen törölve.');
    }
}
