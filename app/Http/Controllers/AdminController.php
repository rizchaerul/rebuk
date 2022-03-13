<?php

namespace App\Http\Controllers;

use App\User;
use App\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        if(auth()->user()->role != 'Admin') {
            return redirect('/home');
        }

        return view('admin', [
            'requests' => Report::get()
        ]);
    }

    public function ban(Request $request) {
        $user = User::where('id', $request->userId)->first();
        $user->banned = 'yes';
        $user->save();
        
        return back();
    }
}
