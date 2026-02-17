@extends('layouts.marketing')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-black/60">Gesprek</p>
                <h1 class="font-display text-4xl">{{ $conversation->listing?->title ?? 'Gesprek' }}</h1>
                <p class="text-base text-black/70">
                    {{ $conversation->seller?->name ?? 'Verkoper' }} • {{ $conversation->buyer?->name ?? 'Koper' }}
                </p>
            </div>
            @if ($conversation->listing)
                <flux:button href="{{ route('listing.show', ['listing' => $conversation->listing->slug]) }}" variant="subtle">Bekijk advertentie</flux:button>
            @endif
        </div>

        <div class="mt-8 grid gap-4 rounded-3xl border border-black/10 bg-white/85 p-6">
            @forelse ($conversation->messages as $message)
                @php
                    $isSender = $message->sender_id === auth()->id();
                @endphp
                <div class="max-w-xl rounded-3xl p-4 text-sm {{ $isSender ? 'ms-auto bg-[color:var(--wp-forest)] text-[color:var(--wp-mist)]' : 'bg-[color:var(--wp-mist)] text-black/70' }}">
                    {{ $message->body }}
                </div>
            @empty
                <p class="text-sm text-black/60">Er zijn nog geen berichten in dit gesprek.</p>
            @endforelse
        </div>

        <form class="mt-6 flex gap-3">
            <flux:input placeholder="Typ je bericht..." class="flex-1" />
            <flux:button variant="primary">Verstuur</flux:button>
        </form>
    </section>
@endsection
