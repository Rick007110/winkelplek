@extends('layouts.marketing')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
        <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="space-y-4">
                <p class="text-sm uppercase tracking-[0.2em] text-black/60">Order</p>
                <h1 class="font-display text-4xl">{{ $order->listing?->title ?? 'Order' }}</h1>
                <p class="text-base text-black/70">Status: {{ $order->status }}</p>
                <div class="rounded-3xl border border-black/10 bg-white/85 p-6">
                    <div class="flex items-center justify-between text-sm text-black/70">
                        <span>Bedrag</span>
                        <span class="font-semibold text-[color:var(--wp-coral)]">
                            {{ $order->currency }} {{ number_format($order->amount / 100, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm text-black/70">
                        <span>Verkoper</span>
                        <span>{{ $order->seller?->name ?? 'Onbekend' }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm text-black/70">
                        <span>Bestelling</span>
                        <span>{{ $order->created_at?->format('d-m-Y') ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="space-y-4 rounded-3xl border border-black/10 bg-white/80 p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-black/60">Escrow</p>
                <p class="text-base text-black/70">
                    Je betaling staat veilig. Bevestig zodra je het item hebt ontvangen en tevreden bent.
                </p>
                <flux:button variant="primary" class="w-full">Bevestig ontvangst</flux:button>
                <flux:button variant="subtle" class="w-full">Open support</flux:button>
            </div>
        </div>
    </section>
@endsection
