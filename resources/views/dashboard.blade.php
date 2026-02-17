<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto w-full max-w-6xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Dashboard</h1>
                <p class="mt-1 text-sm text-black/60">Overzicht van je winkelactiviteiten.</p>
            </div>
            <flux:button href="{{ route('listing.create') }}" variant="primary">Nieuwe advertentie</flux:button>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-black/10 bg-white p-4">
                <p class="text-sm text-black/60">Advertenties</p>
                <p class="text-2xl font-semibold">{{ $listingCount }}</p>
            </div>
            <div class="rounded-lg border border-black/10 bg-white p-4">
                <p class="text-sm text-black/60">Favorieten</p>
                <p class="text-2xl font-semibold">{{ $favoriteCount }}</p>
            </div>
            <div class="rounded-lg border border-black/10 bg-white p-4">
                <p class="text-sm text-black/60">Orders</p>
                <p class="text-2xl font-semibold">{{ $orderCount }}</p>
            </div>
            <div class="rounded-lg border border-black/10 bg-white p-4">
                <p class="text-sm text-black/60">Gesprekken</p>
                <p class="text-2xl font-semibold">{{ $conversationCount }}</p>
            </div>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-lg border border-black/10 bg-white p-4">
                <p class="text-sm font-semibold">Snelle acties</p>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <flux:button href="{{ route('listing.create') }}" variant="subtle" class="text-black/60 hover:text-[color:var(--wp-ink)]">Advertentie plaatsen</flux:button>
                    <flux:button href="{{ route('inbox.index') }}" variant="subtle" class="text-black/60 hover:text-[color:var(--wp-ink)]">Bekijk inbox</flux:button>
                    <flux:button href="{{ route('orders.index') }}" variant="subtle" class="text-black/60 hover:text-[color:var(--wp-ink)]">Bekijk orders</flux:button>
                    <flux:button href="{{ route('favorites.index') }}" variant="subtle" class="text-black/60 hover:text-[color:var(--wp-ink)]">Favorieten beheren</flux:button>
                </div>
            </div>
            <div class="rounded-lg border border-black/10 bg-[color:var(--wp-mist)] p-4">
                <p class="text-sm font-semibold">Tip van WinkelPlek</p>
                <p class="mt-2 text-sm text-black/70">
                    Voeg duidelijke fotos toe en reageer snel om meer interesse te krijgen.
                </p>
            </div>
        </div>
    </div>
</x-layouts::app>
