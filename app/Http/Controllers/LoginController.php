<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index() {
        return view('login');
    }

    function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with([
                'status' => 'is-invalid',
                'email' => $request->email
            ]);
        }

        if(auth()->user()->banned == 'yes') {
            Auth::logout();

            return back()->with([
                'status' => 'banned',
                'email' => $request->email
            ]);
        }

        return redirect('/');
    }

    function logout() {
        Auth::logout();

        return redirect('/');
    }
}
