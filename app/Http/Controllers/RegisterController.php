<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    function index() {
        return view('register');
    }

    function register(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:2000'
        ]);
        
        $uniqueId = uniqid();

        if ($request->hasFile('image')) {
            $filename = '/profileImg/'.$uniqueId.'.'.$request->file('image')->extension();
        }
        else $filename = '/profileImg/blank.jpg';
        

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $filename
        ]);

        if ($request->hasFile('image')) {
            // Storage::put($filename, file_get_contents($request->file('image')));
            $request->file('image')->move('storage/profileImg', $uniqueId.'.'.$request->file('image')->extension());
        }
        

        Auth::attempt($request->only('email', 'password'));
        return redirect('/');
    }
}
