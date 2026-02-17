<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\View\View;

class InboxController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $conversations = Conversation::with(['listing', 'buyer', 'seller'])
            ->when($user, fn ($query) => $query
                ->where('buyer_id', $user->id)
                ->orWhere('seller_id', $user->id))
            ->latest('last_message_at')
            ->get();

        return view('pages.inbox.index', ['conversations' => $conversations, 'user' => $user]);
    }

    public function show(Conversation $conversation): View
    {
        $conversation->load(['listing', 'buyer', 'seller', 'messages.sender']);

        return view('pages.inbox.show', ['conversation' => $conversation]);
    }
}
