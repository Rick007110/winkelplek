<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="wp-theme min-h-screen bg-[var(--wp-cream)] text-[var(--wp-ink)] antialiased">
        <div class="relative flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="pointer-events-none absolute inset-0 z-0 wp-atmosphere"></div>
            <div class="pointer-events-none absolute inset-0 z-0 opacity-30 mix-blend-soft-light wp-noise"></div>

            <div class="relative z-10 flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold" wire:navigate>
                    <span class="grid h-10 w-10 place-items-center rounded-lg bg-[color:var(--wp-ink)] text-white text-sm">W</span>
                    <span class="text-lg">WinkelPlek</span>
                </a>

                <div class="wp-auth-card isolate rounded-xl border border-black/10 bg-white/95 shadow-sm">
                    <div class="px-8 py-7">{{ $slot }}</div>
                </div>
            </div>
        </div>
        @livewireScripts
        @fluxScripts
    </body>
</html>
