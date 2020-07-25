<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use App\Message;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function getMessages()
    {
        return Message::with('user')->get();
    }

    public function broadcastMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->message
        ]);
 
        broadcast(new MessageSent($user, $message))->toOthers();
        return response()->json(['status' => 'Message Sent!']);
    }
}
