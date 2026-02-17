<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\View\View;

class ExploreController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $listings = Listing::with('location')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(12)
            ->get();
        $listingCount = Listing::count();
        $lastUpdated = Listing::latest('updated_at')->value('updated_at');

        return view('pages.explore', compact('categories', 'listings', 'listingCount', 'lastUpdated'));
    }
}
