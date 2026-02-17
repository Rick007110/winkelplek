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

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">Controleer de velden hieronder.</p>
                    <ul class="mt-2 list-disc space-y-1 ps-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('listing.store') }}" class="mt-6 grid gap-6" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 lg:grid-cols-[2fr_1fr]">
                    <flux:input name="title" label="Titel" placeholder="Bijv. Gazelle stadsfiets" value="{{ old('title') }}" required />
                    <flux:select name="category" label="Categorie" required>
                        <option value="">Kies categorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <flux:textarea name="description" label="Beschrijving" rows="6" placeholder="Beschrijf het item zo duidelijk mogelijk" required>
                    {{ old('description') }}
                </flux:textarea>

                <div class="grid gap-4 lg:grid-cols-[1fr_1fr_1fr]">
                    <flux:input name="price_amount" label="Prijs (EUR)" placeholder="Bijv. 150" value="{{ old('price_amount') }}" required />
                    <flux:input name="condition" label="Conditie" placeholder="Bijv. gebruikt" value="{{ old('condition') }}" required />
                    <flux:input name="city" label="Plaats" placeholder="Bijv. Utrecht" value="{{ old('city') }}" required />
                </div>

                <div class="rounded-lg border border-black/10 bg-white p-4">
                    <p class="text-sm font-semibold">Foto's</p>
                    <p class="mt-1 text-sm text-black/60">Upload maximaal 6 foto's (JPG/PNG/WebP).</p>
                    <input
                        type="file"
                        name="images[]"
                        accept="image/*"
                        multiple
                        class="mt-3 block w-full rounded-md border border-black/20 bg-white px-3 py-2 text-sm text-black/70 file:me-4 file:rounded file:border-0 file:bg-[color:var(--wp-ink)] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-black/80"
                    />
                    @error('images')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 rounded-lg border border-black/10 bg-[color:var(--wp-mist)]/60 px-4 py-3 text-sm text-black/70">
                    <input
                        type="checkbox"
                        name="bidding_enabled"
                        value="1"
                        class="h-4 w-4 rounded border-black/30 text-[color:var(--wp-coral)] focus:ring-[color:var(--wp-coral)]"
                        @checked(old('bidding_enabled'))
                    />
                    <span>Bieden toestaan op deze advertentie (standaard uit).</span>
                </label>

                <div class="flex justify-end gap-3">
                    <flux:button variant="subtle" href="{{ route('dashboard') }}">Annuleren</flux:button>
                    <flux:button variant="primary" type="submit">Advertentie opslaan</flux:button>
                </div>
            </form>
        </div>
    </section>
@endsection
