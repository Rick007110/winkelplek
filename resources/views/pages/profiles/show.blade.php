@extends('layouts.marketing')

@section('content')
    @php
        $profile = $user->profile;
        $profileName = $profile->display_name ?? $user->name ?? 'Verkoper';
        $profileCity = optional($profile?->location)->city;
        $listings = $user->listings ?? collect();
        $formatPrice = fn ($amount, $currency = 'EUR') => $amount
            ? $currency . ' ' . number_format($amount / 100, 0, ',', '.')
            : $currency . ' 0';
    @endphp

    <section class="mx-auto w-full max-w-6xl px-6 pb-6 pt-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-md bg-[color:var(--wp-sand)]"></div>
                <div>
                    <p class="text-lg font-semibold">{{ $profileName }}</p>
                    <p class="text-sm text-black/60">
                        {{ $profileCity ?? 'Locatie onbekend' }}
                        @if ($profile)
                            • {{ number_format($profile->rating_average, 1, ',', '.') }}/5 score
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <flux:button variant="primary">Stuur bericht</flux:button>
                <flux:button variant="subtle">Volg verkoper</flux:button>
            </div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-6xl px-6 pb-16">
        <div class="grid gap-6 lg:grid-cols-[0.3fr_0.7fr]">
            <aside class="rounded-lg border border-black/10 bg-white p-4">
                <p class="text-sm font-semibold">Profiel</p>
                <p class="mt-2 text-sm text-black/70">
                    {{ $profile?->bio ?? 'Nog geen profieltekst beschikbaar.' }}
                </p>
                <div class="mt-4 grid gap-2 text-xs text-black/60">
                    <div class="flex items-center justify-between">
                        <span>Verkopen</span>
                        <span>{{ $listings->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Beoordelingen</span>
                        <span>{{ $profile?->rating_count ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Lid sinds</span>
                        <span>{{ $user->created_at?->format('Y') ?? '-' }}</span>
                    </div>
                </div>
            </aside>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Aanbod</h2>
                    <span class="text-sm text-black/60">{{ $listings->count() }} items</span>
                </div>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($listings as $listing)
                        <a href="{{ route('listing.show', ['listing' => $listing->slug]) }}" class="rounded-lg border border-black/10 bg-white p-3 hover:border-black/20">
                            <div class="h-28 rounded-md bg-[color:var(--wp-sand)]/70"></div>
                            <p class="mt-3 text-sm font-semibold">{{ $listing->title }}</p>
                            <p class="text-sm text-[color:var(--wp-coral)]">
                                {{ $formatPrice($listing->price_amount, $listing->currency) }}
                            </p>
                        </a>
                    @empty
                        <p class="text-sm text-black/60">Deze verkoper heeft nog geen advertenties.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
