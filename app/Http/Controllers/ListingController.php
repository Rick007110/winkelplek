<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Bid;
use App\Models\Listing;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function show(Listing $listing): View
    {
        $listing->load(['user.profile', 'category', 'location', 'bids.bidder']);
        $bids = $listing->bids->sortByDesc('amount')->values();

        return view('pages.listings.show', [
            'listing' => $listing,
            'bids' => $bids,
        ]);
    }

    public function create(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('pages.listings.create', ['categories' => $categories]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'category' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:10'],
            'price_amount' => ['required', 'string'],
            'condition' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:120'],
            'bidding_enabled' => ['nullable', 'boolean'],
        ]);

        $priceAmount = $this->parsePriceToCents($data['price_amount']);

        $location = Location::create([
            'city' => $data['city'],
            'country_code' => 'NL',
        ]);

        $slug = $this->uniqueSlug($data['title']);

        $listing = Listing::create([
            'user_id' => $request->user()->id,
            'category_id' => (int) $data['category'],
            'location_id' => $location->id,
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'],
            'price_amount' => $priceAmount,
            'currency' => 'EUR',
            'condition' => $data['condition'],
            'status' => 'published',
            'is_featured' => false,
            'bidding_enabled' => $request->boolean('bidding_enabled'),
            'published_at' => now(),
        ]);

        return redirect()->route('listing.show', ['listing' => $listing->slug]);
    }

    public function bid(Request $request, Listing $listing): RedirectResponse
    {
        if (! $listing->bidding_enabled) {
            return back()->withErrors(['bid_amount' => 'Bieden is niet ingeschakeld voor deze advertentie.']);
        }

        if ($listing->user_id === $request->user()->id) {
            return back()->withErrors(['bid_amount' => 'Je kunt niet bieden op je eigen advertentie.']);
        }

        $data = $request->validate([
            'bid_amount' => ['required', 'string'],
        ]);

        $amount = $this->parsePriceToCents($data['bid_amount']);

        if ($amount <= 0) {
            return back()->withErrors(['bid_amount' => 'Voer een geldig bod in.']);
        }

        $highestBid = $listing->bids()->max('amount');

        if ($highestBid !== null && $amount <= $highestBid) {
            return back()->withErrors(['bid_amount' => 'Je bod moet hoger zijn dan het huidige bod.']);
        }

        if ($highestBid === null && $amount < $listing->price_amount) {
            return back()->withErrors(['bid_amount' => 'Je bod moet minimaal de vraagprijs zijn.']);
        }

        Bid::create([
            'listing_id' => $listing->id,
            'bidder_id' => $request->user()->id,
            'amount' => $amount,
            'currency' => $listing->currency ?? 'EUR',
        ]);

        return back();
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 1;

        while (Listing::where('slug', $slug)->exists()) {
            $suffix += 1;
            $slug = $base.'-'.$suffix;
        }

        return $slug;
    }

    private function parsePriceToCents(string $input): int
    {
        $normalized = str_replace([' ', ','], ['', '.'], $input);
        $value = (float) preg_replace('/[^0-9.]/', '', $normalized);

        return (int) round($value * 100);
    }
}
