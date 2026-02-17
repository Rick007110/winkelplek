@extends('layouts.marketing')

@section('content')
    @php
        $formatPrice = fn ($amount, $currency = 'EUR') => $amount
            ? $currency . ' ' . number_format($amount / 100, 0, ',', '.')
            : $currency . ' 0';
    @endphp
    <section class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-black/60">Orders</p>
                <h1 class="font-display text-4xl">Jouw aankopen</h1>
                <p class="text-base text-black/70">Volg escrow, bezorging en bevestig wanneer je tevreden bent.</p>
            </div>
            <flux:button variant="subtle">Filter status</flux:button>
        </div>

        @if ($orders->isEmpty())
            <div class="mt-8 rounded-3xl border border-black/10 bg-white/80 p-6 text-center">
                <p class="font-semibold">Nog geen orders</p>
                <p class="mt-2 text-sm text-black/60">Je aankopen en verkopen verschijnen hier.</p>
            </div>
        @else
            <div class="mt-8 grid gap-4">
                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="flex items-center justify-between rounded-3xl border border-black/10 bg-white/90 p-4">
                        <div>
                            <p class="font-semibold">{{ $order->listing?->title ?? 'Order' }}</p>
                            <p class="text-sm text-black/60">{{ $order->status }}</p>
                        </div>
                        <span class="text-sm text-[color:var(--wp-coral)]">
                            {{ $formatPrice($order->amount, $order->currency) }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
