<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($chatPartner) {
        $id = $chatPartner;

        $chats = Chat::where(function($q) use ($id) { 
            $q->where('sender_id', $id)->where('receiver_id', auth()->user()->id);
        })
        ->orWhere(function($q) use ($id) { 
            $q->where('receiver_id', $id)->Where('sender_id', auth()->user()->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return view('chat', [
            'partner' => User::where('id', $chatPartner)->first(),
            'chats' => $chats
        ]);
    }

    public function send(Request $request) {
        $this->validate($request, [
            'message' => 'required',
            'id' => 'required'
        ]);

        Chat::create([
            'message' => $request->message,
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->id,
        ]);

        return back();
    }
}
