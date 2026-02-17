@extends('layouts.marketing')

@section('content')
    @php
        $formatPrice = fn ($amount, $currency = 'EUR') => $amount
            ? $currency . ' ' . number_format($amount / 100, 0, ',', '.')
            : $currency . ' 0';
    @endphp
    <section class="mx-auto w-full max-w-6xl px-6 pb-6 pt-6">
        <div class="grid gap-6 lg:grid-cols-[0.32fr_0.68fr]">
            <aside class="rounded-lg border border-black/10 bg-white">
                <div class="border-b border-black/10 px-4 py-3 text-sm font-semibold">Categorieen</div>
                <ul class="divide-y divide-black/5 text-sm">
                    @forelse ($categories as $category)
                        <li class="px-4 py-3">
                            <a href="{{ route('explore', ['category' => $category->slug]) }}" class="text-black/80 hover:text-[color:var(--wp-ink)]">
                                {{ $category->name }}
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-3 text-black/60">Nog geen categorieen beschikbaar.</li>
                    @endforelse
                </ul>
            </aside>

            <div class="space-y-6">
                <div class="rounded-lg border border-black/10 bg-[color:var(--wp-mist)] p-6">
                    <h1 class="text-2xl font-semibold">De vertrouwde marktplaats, nu net wat sneller.</h1>
                    <p class="mt-2 text-sm text-black/70">Zoek lokaal, vergelijk prijzen en regel contact veilig op een plek.</p>
                    <form action="{{ route('explore') }}" method="get" class="mt-4 grid gap-3 lg:grid-cols-[2fr_1fr_1fr_auto]">
                        <flux:input name="q" placeholder="Wat zoek je?" />
                        <flux:select name="category">
                            <option value="">Alle categorieen</option>
                            <option>Fietsen en brommers</option>
                            <option>Elektronica</option>
                            <option>Huis en inrichting</option>
                        </flux:select>
                        <flux:select name="distance">
                            <option value="5">Binnen 5 km</option>
                            <option value="10" selected>Binnen 10 km</option>
                            <option value="25">Binnen 25 km</option>
                        </flux:select>
                        <flux:button type="submit" variant="primary">Zoeken</flux:button>
                    </form>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg border border-black/10 bg-white p-4">
                        <p class="text-lg font-semibold">{{ number_format($listingCount ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-black/60">advertenties live</p>
                    </div>
                    <div class="rounded-lg border border-black/10 bg-white p-4">
                        <p class="text-lg font-semibold">{{ number_format($categoryCount ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-black/60">categorieen</p>
                    </div>
                    <div class="rounded-lg border border-black/10 bg-white p-4">
                        <p class="text-lg font-semibold">
                            {{ $ratingAverage ? number_format($ratingAverage, 1, ',', '.') . '/5' : '0/5' }}
                        </p>
                        <p class="text-xs text-black/60">gemiddelde score</p>
                    </div>
                </div>

                <div class="rounded-lg border border-black/10 bg-white">
                    <div class="flex items-center justify-between border-b border-black/10 px-4 py-3 text-sm">
                        <span class="font-semibold">Uitgelicht in de buurt</span>
                        <a href="{{ route('explore') }}" class="text-black/60 hover:text-[color:var(--wp-ink)]">Bekijk alles</a>
                    </div>
                    <div class="grid gap-4 p-4 sm:grid-cols-2">
                        @forelse ($featuredListings as $listing)
                            <a href="{{ route('listing.show', ['listing' => $listing->slug]) }}" class="flex gap-4 rounded-lg border border-black/10 bg-white p-3 hover:border-black/20">
                                <div class="h-20 w-20 rounded-md bg-[color:var(--wp-sand)]"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold">{{ $listing->title }}</p>
                                    <p class="text-xs text-black/60">
                                        {{ optional($listing->location)->city ?? 'Onbekend' }}
                                    </p>
                                    <p class="mt-2 text-sm font-semibold text-[color:var(--wp-coral)]">
                                        {{ $formatPrice($listing->price_amount, $listing->currency) }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-black/60">Er zijn nog geen uitgelichte advertenties.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="categorieen" class="mx-auto w-full max-w-6xl px-6 pb-10">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Populaire categorieen</h2>
            <a href="{{ route('explore') }}" class="text-sm text-black/60 hover:text-[color:var(--wp-ink)]">Alles bekijken</a>
        </div>
        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($categories as $category)
                <a href="{{ route('explore', ['category' => $category->slug]) }}" class="rounded-lg border border-black/10 bg-white px-4 py-3 text-sm hover:border-black/20">
                    {{ $category->name }}
                </a>
            @empty
                <p class="text-sm text-black/60">Nog geen categorieen beschikbaar.</p>
            @endforelse
        </div>
    </section>
@endsection
