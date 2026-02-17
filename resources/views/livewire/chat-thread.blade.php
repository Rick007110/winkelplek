<div wire:poll.3s class="mt-8">
    <div class="grid gap-4 rounded-3xl border border-black/10 bg-white/85 p-6">
        @forelse ($messages as $message)
            @php
                $isSender = $message->sender_id === auth()->id();
            @endphp
            <div wire:key="message-{{ $message->id }}" class="max-w-xl rounded-3xl p-4 text-sm {{ $isSender ? 'ms-auto bg-[color:var(--wp-forest)] text-[color:var(--wp-mist)]' : 'bg-[color:var(--wp-mist)] text-black/70' }}">
                {{ $message->body }}
            </div>
        @empty
            <p class="text-sm text-black/60">Er zijn nog geen berichten in dit gesprek.</p>
        @endforelse
    </div>

    <form wire:submit.prevent="send" class="mt-6 flex gap-3">
        <flux:input wire:model.live="body" placeholder="Typ je bericht..." class="flex-1" />
        <flux:button variant="primary" type="submit">Verstuur</flux:button>
    </form>

    @error('body')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
