<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'array',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => User::class,
            'model_id'    => $user->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' created user ' . $user->name,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles'    => 'array',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => bcrypt($validated['password'])]);
        }

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => User::class,
            'model_id'    => $user->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated user ' . $user->name,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $userName = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => User::class,
            'model_id'    => $user->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted user ' . $userName,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}