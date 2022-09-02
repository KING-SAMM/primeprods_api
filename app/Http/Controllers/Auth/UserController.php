<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Get all users
     */
    public function index() {
        return response()->json([
            'users' => User::all()
        ]);
    }


    /**
     * Get user
     */
    public function show(User $user) {
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Store the created User
     */
    public function store(Request $request)
    {
        // Validate the data
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required | confirmed | min:6'
        ]);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create the user
        $user = User::create($formFields);

        // Automatically login the created user
        auth()->login($user);

        // Redirect with flash message
        return response()->json([
            'message' => 'User created and logged in'
        ]);
    }
}
