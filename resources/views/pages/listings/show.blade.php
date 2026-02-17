@extends('layouts.marketing')

@section('content')
    @php
        $listingTitle = $listing->title ?? 'Onbekende advertentie';
        $listingPrice = $listing->price_amount
            ? ($listing->currency ?? 'EUR') . ' ' . number_format($listing->price_amount / 100, 0, ',', '.')
            : ($listing->currency ?? 'EUR') . ' 0';
        $listingLocation = optional($listing->location)->city;
        $sellerName = optional($listing->user)->name ?? 'Verkoper';
        $sellerProfile = optional($listing->user)->profile;
    @endphp

    <section class="mx-auto w-full max-w-6xl px-6 pb-6 pt-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold">{{ $listingTitle }}</h1>
                <p class="mt-1 text-sm text-black/60">
                    {{ $listingLocation ?? 'Locatie onbekend' }}
                </p>
            </div>
            <div class="text-xl font-semibold text-[color:var(--wp-coral)]">{{ $listingPrice }}</div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-6xl px-6 pb-16">
        <div class="grid gap-6 lg:grid-cols-[0.65fr_0.35fr]">
            <div class="space-y-4">
                <div class="h-72 rounded-lg border border-black/10 bg-[color:var(--wp-sand)]/70"></div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="h-24 rounded-md bg-[color:var(--wp-amber)]/30"></div>
                    <div class="h-24 rounded-md bg-[color:var(--wp-teal)]/20"></div>
                    <div class="h-24 rounded-md bg-[color:var(--wp-mist)]"></div>
                </div>

                <div class="rounded-lg border border-black/10 bg-white p-4">
                    <h2 class="text-sm font-semibold">Beschrijving</h2>
                    <p class="mt-2 text-sm text-black/70">
                        {{ $listing->description ?? 'Geen beschrijving beschikbaar.' }}
                    </p>
                </div>

                <div class="rounded-lg border border-black/10 bg-white p-4">
                    <h2 class="text-sm font-semibold">Details</h2>
                    <div class="mt-3 grid gap-2 text-sm text-black/70">
                        <div class="flex items-center justify-between">
                            <span>Categorie</span>
                            <span>{{ optional($listing->category)->name ?? 'Onbekend' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Conditie</span>
                            <span>{{ $listing->condition ?? 'Onbekend' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Status</span>
                            <span>{{ $listing->status ?? 'Onbekend' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Geplaatst</span>
                            <span>{{ optional($listing->published_at)->format('d-m-Y') ?? 'Onbekend' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-4">
                <div class="rounded-lg border border-black/10 bg-white p-4">
                    <p class="text-sm font-semibold">Verkoper</p>
                    <div class="mt-3 flex items-center gap-3">
                        <div class="h-12 w-12 rounded-md bg-[color:var(--wp-sand)]"></div>
                        <div>
                            <p class="text-sm font-semibold">{{ $sellerName }}</p>
                            @if ($sellerProfile)
                                <p class="text-xs text-black/60">
                                    {{ number_format($sellerProfile->rating_average, 1, ',', '.') }}/5 • {{ $sellerProfile->rating_count }} reviews
                                </p>
                            @else
                                <p class="text-xs text-black/60">Nog geen beoordelingen</p>
                            @endif
                        </div>
                    </div>
                    <flux:button href="{{ route('profile.show', ['user' => $listing->user_id ?? 1]) }}" variant="subtle" class="mt-4 w-full">
                        Bekijk profiel
                    </flux:button>
                </div>

                <div class="rounded-lg border border-black/10 bg-white p-4">
                    <flux:button variant="primary" class="w-full">Stuur bericht</flux:button>
                    <flux:button variant="subtle" class="mt-2 w-full">Doe een bod</flux:button>
                </div>

                <div class="rounded-lg border border-black/10 bg-[color:var(--wp-mist)] p-4 text-sm text-black/70">
                    Je kunt veilig contact opnemen en afspraken maken via WinkelPlek.
                </div>
            </aside>
        </div>
    </section>
@endsection
