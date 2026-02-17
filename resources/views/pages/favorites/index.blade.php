@extends('layouts.marketing')

@section('content')
    @php
        $formatPrice = fn ($amount, $currency = 'EUR') => $amount
            ? $currency . ' ' . number_format($amount / 100, 0, ',', '.')
            : $currency . ' 0';
    @endphp
    <section class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-black/60">Favorieten</p>
                <h1 class="font-display text-4xl">Jouw lijst met parels</h1>
                <p class="text-base text-black/70">Bewaar items om later te vergelijken of meteen een bericht te sturen.</p>
            </div>
            <flux:button variant="subtle">Deel lijst</flux:button>
        </div>

        @if ($favorites->isEmpty())
            <div class="mt-8 rounded-3xl border border-black/10 bg-white/80 p-6 text-center">
                <p class="font-semibold">Nog geen favorieten</p>
                <p class="mt-2 text-sm text-black/60">Ontdek aanbod en sla items op die je wilt volgen.</p>
                <flux:button href="{{ route('explore') }}" variant="primary" class="mt-4">Ontdek aanbod</flux:button>
            </div>
        @else
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($favorites as $listing)
                    <a href="{{ route('listing.show', ['listing' => $listing->slug]) }}" class="rounded-lg border border-black/10 bg-white p-4 hover:border-black/20">
                        <div class="h-36 rounded-md bg-[color:var(--wp-sand)]/70"></div>
                        <div class="mt-3">
                            <p class="text-sm font-semibold">{{ $listing->title }}</p>
                            <p class="text-xs text-black/60">{{ optional($listing->location)->city ?? 'Onbekend' }}</p>
                            <p class="mt-2 text-sm font-semibold text-[color:var(--wp-coral)]">
                                {{ $formatPrice($listing->price_amount, $listing->currency) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
