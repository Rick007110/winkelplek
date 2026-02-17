<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="wp-theme min-h-screen bg-[var(--wp-cream)] text-[var(--wp-ink)] antialiased">
        <div class="relative overflow-hidden">
            <div class="pointer-events-none absolute inset-0 wp-atmosphere"></div>
            <div class="pointer-events-none absolute inset-y-0 start-0 w-2/3 opacity-60 wp-grid"></div>
            <div class="pointer-events-none absolute -top-24 end-6 h-56 w-56 rounded-full bg-[color:var(--wp-coral)] opacity-20 blur-3xl"></div>
            <div class="pointer-events-none absolute top-40 end-28 h-64 w-64 rounded-full bg-[color:var(--wp-teal)] opacity-15 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 start-12 h-72 w-72 rounded-full bg-[color:var(--wp-amber)] opacity-20 blur-3xl"></div>
            <div class="pointer-events-none absolute inset-0 opacity-60 mix-blend-soft-light wp-noise"></div>

            <header class="relative z-10">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-[color:var(--wp-ink)] text-[color:var(--wp-mist)] font-display text-lg">W</span>
                        <span class="font-display text-xl tracking-tight">WinkelPlek</span>
                    </a>

                    <nav class="hidden items-center gap-8 text-sm font-medium md:flex">
                        <a href="{{ route('explore') }}" class="transition hover:text-[color:var(--wp-coral)]">Ontdek</a>
                        <a href="#categorieen" class="transition hover:text-[color:var(--wp-coral)]">Categorieen</a>
                        <a href="#hoe-het-werkt" class="transition hover:text-[color:var(--wp-coral)]">Hoe het werkt</a>
                        <a href="#verkopen" class="transition hover:text-[color:var(--wp-coral)]">Verkopen</a>
                    </nav>

                    @if (Route::has('login'))
                        <div class="hidden items-center gap-3 md:flex">
                            @auth
                                <flux:button href="{{ route('dashboard') }}" variant="subtle">Dashboard</flux:button>
                            @else
                                <flux:button href="{{ route('login') }}" variant="subtle">Inloggen</flux:button>
                                @if (Route::has('register'))
                                    <flux:button href="{{ route('register') }}" variant="primary">Account aanmaken</flux:button>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <div class="md:hidden">
                        <flux:button href="{{ route('explore') }}" variant="primary">Ontdek</flux:button>
                    </div>
                </div>
            </header>

            <main class="relative z-10">
                {{ $slot }}
            </main>

            <footer class="relative z-10 border-t border-black/10">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-6 py-10 text-sm md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <p class="font-display text-lg">WinkelPlek</p>
                        <p class="text-black/60">De moderne marktplaats voor spullen met een verhaal.</p>
                    </div>
                    <div class="flex flex-wrap gap-4 text-black/60">
                        <a href="{{ route('explore') }}" class="transition hover:text-[color:var(--wp-ink)]">Ontdek</a>
                        <a href="#hoe-het-werkt" class="transition hover:text-[color:var(--wp-ink)]">Hoe het werkt</a>
                        <a href="#verkopen" class="transition hover:text-[color:var(--wp-ink)]">Verkopen</a>
                        <a href="#categorieen" class="transition hover:text-[color:var(--wp-ink)]">Categorieen</a>
                    </div>
                </div>
            </footer>
        </div>

        @fluxScripts
    </body>
</html>
