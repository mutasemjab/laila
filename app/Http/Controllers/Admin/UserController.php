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
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|in:1,2',
            'category' => 'required|in:1,2,3',
            'phone' => 'required|string|max:255|unique:users',
            'activate' => 'required|in:1,2',
        ]);

        $user = new User();
        $user->title = $validatedData['title'];
        $user->first_name = $validatedData['first_name'];
        $user->second_name = $validatedData['second_name'];
        $user->last_name = $validatedData['last_name'];
        $user->company = $validatedData['company'];
        $user->country = $validatedData['country'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->category = $validatedData['category'];
        $user->phone = $validatedData['phone'];
        $user->activate = $validatedData['activate'];
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
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.users.edit', compact('data'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required|in:1,2',
            'category' => 'required|in:1,2,3',
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'activate' => 'required|in:1,2',
        ]);

        $user->title = $validatedData['title'];
        $user->first_name = $validatedData['first_name'];
        $user->second_name = $validatedData['second_name'];
        $user->last_name = $validatedData['last_name'];
        $user->company = $validatedData['company'];
        $user->country = $validatedData['country'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->category = $validatedData['category'];
        $user->phone = $validatedData['phone'];
        $user->activate = $validatedData['activate'];

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
