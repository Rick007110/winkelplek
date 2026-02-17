<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Listing;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $user = auth()->user();
        if (! $user || ($conversation->buyer_id !== $user->id && $conversation->seller_id !== $user->id)) {
            abort(403);
        }

        $conversation->load(['listing', 'buyer', 'seller', 'messages.sender']);

        return view('pages.inbox.show', ['conversation' => $conversation]);
    }

    public function store(Request $request, Conversation $conversation): RedirectResponse
    {
        $user = $request->user();
        if ($conversation->buyer_id !== $user->id && $conversation->seller_id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2'],
        ]);

        $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $data['body'],
        ]);

        $conversation->update(['last_message_at' => Carbon::now()]);

        return back();
    }

    public function start(Request $request, Listing $listing): RedirectResponse
    {
        $user = $request->user();
        if ($listing->user_id === $user->id) {
            return back()->withErrors(['body' => 'Je kunt jezelf geen bericht sturen.']);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2'],
        ]);

        $conversation = Conversation::firstOrCreate([
            'listing_id' => $listing->id,
            'buyer_id' => $user->id,
            'seller_id' => $listing->user_id,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $data['body'],
        ]);

        $conversation->update(['last_message_at' => Carbon::now()]);

        return redirect()->route('inbox.show', ['conversation' => $conversation->id]);
    }
}
