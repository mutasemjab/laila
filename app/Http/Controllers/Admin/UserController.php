<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }
    
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users',
        ]);
        
        $user = new User();
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->barcode = User::generateUniqueBarcode();
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    
    /**
     * Display the specified user and their barcode.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    
    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
