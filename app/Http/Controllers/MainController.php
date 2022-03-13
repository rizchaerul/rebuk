<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    function topup($amount) {
        $user = User::where('id', auth()->user()->id)->first();

        $user->coin += $amount;
        $user->save();

        return back();
    }

    function withdraw(Request $request) {
        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);
        
        $amount = $request->amount;
        $user = User::where('id', auth()->user()->id)->first();

        $user->coin -= $amount;
        $user->save();

        return back();
    }
}
