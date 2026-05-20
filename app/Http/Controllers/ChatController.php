<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }


    public function fetchMessages(Request $request)
    {
        $group = $request->query('group', 'all');
        return Message::with('user')->where('group', $group)->get();
    }


    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'group' => 'required|string|max:50',
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'group' => $request->group,
        ]);

        return $message->load('user');
    }

    public function deleteMessage(Message $message)
    {
        /** @var mixed $authUser */
        $authUser = Auth::user();

        $isOwner = Auth::id() === $message->user_id;
        $isPrivileged = $authUser
            && method_exists($authUser, 'hasAnyRole')
            && $authUser->hasAnyRole(['admin', 'project_manager', 'pm']);

        // Only allow the owner or privileged roles to delete.
        if (! $isOwner && ! $isPrivileged) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $message->delete();
        return response()->json(['success' => true]);
    }
}
