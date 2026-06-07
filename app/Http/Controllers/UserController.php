<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditLog;

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::all();
        $totalUsers = User::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalNurses = User::where('role', 'nurse')->count();
        $securityEvents = \App\Models\AuditLog::whereDate('created_at', today())->count();

        return view('users.index', compact('users', 'totalUsers', 'totalDoctors', 'totalNurses', 'securityEvents'));
    }

    // Show create form
    public function create()
    {
        return view('users.create');
    }

    // Save new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,doctor,nurse,receptionist',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Log the action
        AuditLog::create([
            'user_id'     => auth()->id(),
            'user_name'   => auth()->user()->name,
            'action'      => 'created',
            'module'      => 'Users',
            'description' => auth()->user()->name . ' created user: ' . $user->name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }   

    // Show edit form
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role'  => 'required|in:admin,doctor,nurse,receptionist',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        // Log the action
        AuditLog::create([
            'user_id'     => auth()->id(),
            'user_name'   => auth()->user()->name,
            'action'      => 'updated',
            'module'      => 'Users',
            'description' => auth()->user()->name . ' updated user: ' . $user->name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Log the action before deleting
        AuditLog::create([
            'user_id'     => auth()->id(),
            'user_name'   => auth()->user()->name,
            'action'      => 'deleted',
            'module'      => 'Users',
            'description' => auth()->user()->name . ' deleted user: ' . $user->name,
            'ip_address'  => request()->ip(),
        ]);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}