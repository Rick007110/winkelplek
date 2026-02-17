<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="wp-theme min-h-screen bg-[var(--wp-cream)] text-[var(--wp-ink)] antialiased">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col border-e border-black/10 bg-[color:var(--wp-forest)] p-10 text-[color:var(--wp-mist)] lg:flex">
                <div class="pointer-events-none absolute inset-0 z-0 opacity-20 wp-noise"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-semibold" wire:navigate>
                    <span class="grid h-10 w-10 place-items-center rounded-lg bg-white text-[color:var(--wp-forest)] text-sm">W</span>
                    <span class="ms-2">WinkelPlek</span>
                </a>

                <div class="relative z-20 mt-auto space-y-3">
                    <p class="text-2xl font-semibold">Verkoop en koop lokaal met vertrouwen.</p>
                    <p class="text-sm text-[color:var(--wp-mist)]/80">
                        Snelle reacties, duidelijke afspraken en moderne tools voor buurt en stad.
                    </p>
                </div>
            </div>
            <div class="relative w-full lg:p-8">
                <div class="pointer-events-none absolute inset-0 z-0 opacity-30 mix-blend-soft-light wp-atmosphere"></div>
                <div class="relative z-10 mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[380px]">
                    <a href="{{ route('home') }}" class="z-20 flex items-center gap-3 font-semibold lg:hidden" wire:navigate>
                        <span class="grid h-10 w-10 place-items-center rounded-lg bg-[color:var(--wp-ink)] text-white text-sm">W</span>
                        <span class="text-lg">WinkelPlek</span>
                    </a>
                    <div class="wp-auth-card isolate rounded-xl border border-black/10 bg-white/95 p-6 shadow-sm">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @livewireScripts
        @fluxScripts
    </body>
</html>
