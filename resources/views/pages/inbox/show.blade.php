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

        <livewire:chat-thread :conversation="$conversation" />
    </section>
@endsection
