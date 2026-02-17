@extends('layouts.marketing')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-black/60">Inbox</p>
                <h1 class="font-display text-4xl">Jouw gesprekken</h1>
                <p class="text-base text-black/70">Chat met verkopers en regel de beste deal.</p>
            </div>
            <flux:button variant="primary">Nieuw bericht</flux:button>
        </div>

        @if ($conversations->isEmpty())
            <div class="mt-8 rounded-3xl border border-black/10 bg-white/80 p-6 text-center">
                <p class="font-semibold">Nog geen gesprekken</p>
                <p class="mt-2 text-sm text-black/60">Stuur een bericht vanaf een advertentie om te starten.</p>
            </div>
        @else
            <div class="mt-8 grid gap-4">
                @foreach ($conversations as $conversation)
                    @php
                        $otherUser = $conversation->buyer_id === $user?->id ? $conversation->seller : $conversation->buyer;
                    @endphp
                    <a href="{{ route('inbox.show', ['conversation' => $conversation->id]) }}" class="flex items-center justify-between rounded-3xl border border-black/10 bg-white/90 p-4">
                        <div>
                            <p class="font-semibold">{{ $conversation->listing?->title ?? 'Gesprek' }}</p>
                            <p class="text-sm text-black/60">
                                {{ $otherUser?->name ?? 'Gebruiker' }}
                                @if ($conversation->last_message_at)
                                    • {{ $conversation->last_message_at->format('d-m-Y H:i') }}
                                @endif
                            </p>
                        </div>
                        <span class="text-xs text-black/50">
                            {{ $conversation->status ?? 'open' }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
