<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="wp-theme min-h-screen bg-[var(--wp-cream)] text-[var(--wp-ink)] antialiased">
        <div class="relative min-h-screen">
            <div class="pointer-events-none absolute inset-0 wp-atmosphere"></div>
            <div class="pointer-events-none absolute inset-0 opacity-40 mix-blend-soft-light wp-noise"></div>

            <header class="relative border-b border-black/10 bg-[color:var(--wp-mist)]">
                <div class="mx-auto flex w-full max-w-6xl flex-wrap items-center gap-4 px-6 py-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-lg bg-[color:var(--wp-ink)] text-white text-sm font-semibold">W</span>
                        <span class="text-lg font-semibold">WinkelPlek</span>
                    </a>

                    <form action="{{ route('explore') }}" method="get" class="flex w-full flex-1 items-center gap-2 sm:w-auto">
                        <flux:input name="q" placeholder="Zoek op merk, titel of trefwoord" class="w-full" />
                        <flux:button type="submit" variant="primary">Zoek</flux:button>
                    </form>

                    @if (Route::has('login'))
                        <div class="ms-auto hidden items-center gap-3 md:flex">
                            @auth
                                <flux:button href="{{ route('dashboard') }}" variant="subtle">Mijn account</flux:button>
                                <flux:button href="{{ route('listing.create') }}" variant="subtle">Plaats advertentie</flux:button>
                            @else
                                <flux:button href="{{ route('login') }}" variant="subtle">Inloggen</flux:button>
                                @if (Route::has('register'))
                                    <flux:button href="{{ route('register') }}" variant="primary">Registreren</flux:button>
                                @endif
                                <flux:button href="{{ route('login') }}" variant="subtle">Plaats advertentie</flux:button>
                            @endauth
                        </div>
                    @endif
                </div>
                <div class="border-t border-black/10 bg-white/80">
                    <div class="mx-auto flex w-full max-w-6xl flex-wrap items-center gap-4 px-6 py-3 text-sm">
                        <a href="{{ route('explore') }}" class="font-semibold">Alle categorieen</a>
                        <a href="#categorieen" class="text-black/70">Fietsen</a>
                        <a href="#categorieen" class="text-black/70">Auto's</a>
                        <a href="#categorieen" class="text-black/70">Elektronica</a>
                        <a href="#categorieen" class="text-black/70">Meubels</a>
                        <a href="#categorieen" class="text-black/70">Kleding</a>
                        <a href="#categorieen" class="text-black/70">Hobby</a>
                        <a href="#categorieen" class="text-black/70">Diensten</a>
                    </div>
                </div>
            </header>

            <main class="relative">
                @yield('content')
            </main>

            <footer class="relative border-t border-black/10 bg-[color:var(--wp-mist)]">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-6 py-8 text-sm md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1">
                        <p class="font-semibold">WinkelPlek</p>
                        <p class="text-black/60">De vertrouwde marktplaats in een moderner jasje.</p>
                    </div>
                    <div class="flex flex-wrap gap-4 text-black/60">
                        <a href="{{ route('explore') }}" class="transition hover:text-[color:var(--wp-ink)]">Ontdek</a>
                        @auth
                            <a href="{{ route('listing.create') }}" class="transition hover:text-[color:var(--wp-ink)]">Verkopen</a>
                        @else
                            <a href="{{ route('login') }}" class="transition hover:text-[color:var(--wp-ink)]">Verkopen</a>
                        @endauth
                        <a href="#categorieen" class="transition hover:text-[color:var(--wp-ink)]">Categorieen</a>
                    </div>
                </div>
            </footer>
        </div>

        @livewireScripts
        @fluxScripts
    </body>
</html>
