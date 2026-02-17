@extends('layouts.marketing')

@section('content')
    <section class="mx-auto w-full max-w-6xl px-6 pb-12 pt-6">
        <div class="rounded-lg border border-black/10 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">Nieuwe advertentie</h1>
                    <p class="mt-1 text-sm text-black/60">Vul de gegevens in om je advertentie te plaatsen.</p>
                </div>
            </div>

            <form class="mt-6 grid gap-6">
                <div class="grid gap-4 lg:grid-cols-[2fr_1fr]">
                    <flux:input name="title" label="Titel" placeholder="Bijv. Gazelle stadsfiets" required />
                    <flux:select name="category" label="Categorie" required>
                        <option value="">Kies categorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <flux:textarea name="description" label="Beschrijving" rows="6" placeholder="Beschrijf het item zo duidelijk mogelijk" required />

                <div class="grid gap-4 lg:grid-cols-[1fr_1fr_1fr]">
                    <flux:input name="price_amount" label="Prijs (EUR)" placeholder="Bijv. 150" required />
                    <flux:input name="condition" label="Conditie" placeholder="Bijv. gebruikt" required />
                    <flux:input name="city" label="Plaats" placeholder="Bijv. Utrecht" required />
                </div>

                <div class="flex justify-end gap-3">
                    <flux:button variant="subtle" href="{{ route('dashboard') }}">Annuleren</flux:button>
                    <flux:button variant="primary" type="submit">Advertentie opslaan</flux:button>
                </div>
            </form>
        </div>
    </section>
@endsection
