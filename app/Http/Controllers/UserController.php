<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function user()
    {
        $users = User::all(); 
        return view('users.user', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // If you only want to update name, no need for email here
        ]);
    
        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->save();
    
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.user')->with('success', 'User deleted successfully!');
    }


    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'loginEmail' => 'required|email',
            'loginPassword' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('loginEmail'),
            'password' => $request->input('loginPassword'),
        ];

        if (Auth::attempt($credentials)) {
            $username = Auth::user()->name;
            return redirect('/')->with('success', "Welcome $username");
        }    
        
        return back()->withErrors(['login' => 'Invalid email or password']);
    }

    public function create()
    {
        return view('auth.register');
    }
    
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
        ]);
    
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    
        return redirect()->route('register.form')->with('success', 'User registered successfully!');
    }
}