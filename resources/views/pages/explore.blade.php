@extends('layouts.marketing')

@section('content')
    @php
        $formatPrice = fn ($amount, $currency = 'EUR') => $amount
            ? $currency . ' ' . number_format($amount / 100, 0, ',', '.')
            : $currency . ' 0';
    @endphp
    <section class="mx-auto w-full max-w-6xl px-6 pb-6 pt-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-black/60">Ontdek</p>
                <h1 class="text-2xl font-semibold">Alles wat dichtbij voelt.</h1>
                <p class="mt-1 text-sm text-black/70">
                    {{ number_format($listingCount ?? 0, 0, ',', '.') }} items in jouw omgeving.
                </p>
            </div>
            <div class="text-sm text-black/60">
                Laatste update: {{ $lastUpdated ? $lastUpdated->format('d-m-Y H:i') : 'onbekend' }}
            </div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-6xl px-6 pb-20">
        <div class="grid gap-6 lg:grid-cols-[0.3fr_0.7fr]">
            <aside class="rounded-lg border border-black/10 bg-white p-4">
                <form class="grid gap-4">
                    <flux:field>
                        <flux:label>Zoeken</flux:label>
                        <flux:input name="q" placeholder="Zoek op titel of merk" />
                    </flux:field>
                    <flux:field>
                        <flux:label>Categorie</flux:label>
                        <flux:select name="category">
                            <option value="">Alle categorieen</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                    <flux:field>
                        <flux:label>Afstand</flux:label>
                        <flux:select name="distance">
                            <option value="5">Binnen 5 km</option>
                            <option value="10" selected>Binnen 10 km</option>
                            <option value="25">Binnen 25 km</option>
                        </flux:select>
                    </flux:field>
                    <flux:field>
                        <flux:label>Prijs tot</flux:label>
                        <flux:input name="max_price" placeholder="EUR" />
                    </flux:field>
                    <flux:button type="submit" variant="primary" class="w-full">Filters toepassen</flux:button>
                </form>
            </aside>

            <div class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-black/10 bg-white px-4 py-3 text-sm">
                    <span>Resultaten in jouw buurt</span>
                    <div class="flex items-center gap-2">
                        <span class="text-black/60">Sorteer:</span>
                        <select class="rounded-md border border-black/10 bg-white px-2 py-1 text-sm">
                            <option>Meest relevant</option>
                            <option>Laagste prijs</option>
                            <option>Hoogste prijs</option>
                            <option>Nieuwste</option>
                        </select>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($listings as $listing)
                        <a href="{{ route('listing.show', ['listing' => $listing->slug]) }}" class="rounded-lg border border-black/10 bg-white p-3 hover:border-black/20">
                            <div class="h-36 rounded-md bg-[color:var(--wp-sand)]/70"></div>
                            <div class="mt-3 space-y-1">
                                <p class="text-sm font-semibold">{{ $listing->title }}</p>
                                <p class="text-xs text-black/60">{{ optional($listing->location)->city ?? 'Onbekend' }}</p>
                                <p class="text-sm font-semibold text-[color:var(--wp-coral)]">
                                    {{ $formatPrice($listing->price_amount, $listing->currency) }}
                                </p>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-xs text-black/60">
                                <span>{{ $listing->status === 'published' ? 'Geverifieerde verkoper' : 'Advertentie' }}</span>
                                <span class="rounded-full bg-[color:var(--wp-mist)] px-2 py-1">Nieuw</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-black/60">Er zijn nog geen advertenties beschikbaar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
