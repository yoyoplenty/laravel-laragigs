<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller {
    //Get Register Form
    public function register() {
        //Return should always be here
        return view('users.register');
    }

    //Create a new User
    public function store(Request $request) {

        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6',
        ]);

        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create User
        $user = User::create($formFields);

        //Login 
        auth()->login($user);

        return redirect('/')->with('message',  'User created successfully');
    }

    //Log User Out
    public function logout(Request $request) {

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message',  'User successfully logged out');
    }

    //Show Login Form
    public function login() {

        return view('users.login');
    }

    //Login User
    public function authenticate(Request $request) {

        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerateToken();

            return redirect('/')->with('message',  'User successfully logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
