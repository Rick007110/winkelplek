<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\Component;

class ChatThread extends Component
{
    public Conversation $conversation;
    public string $body = '';

    public function mount(Conversation $conversation): void
    {
        $user = auth()->user();

        if (! $user || ($conversation->buyer_id !== $user->id && $conversation->seller_id !== $user->id)) {
            abort(403);
        }

        $this->conversation = $conversation;
    }

    public function send(): void
    {
        $this->validate([
            'body' => ['required', 'string', 'min:2'],
        ]);

        $this->conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body' => $this->body,
        ]);

        $this->conversation->update(['last_message_at' => now()]);

        $this->reset('body');
    }

    public function getMessagesProperty()
    {
        return $this->conversation
            ->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.chat-thread', [
            'messages' => $this->messages,
        ]);
    }
}
