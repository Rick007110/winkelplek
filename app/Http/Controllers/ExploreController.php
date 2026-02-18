<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('sort_order')->get();
        
        // Start building the query
        $query = Listing::with(['location', 'category', 'photos'])
            ->where('status', 'published');

        // Search filter
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categorySlug = $request->input('category')) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Price filter
        if ($maxPrice = $request->input('max_price')) {
            // Convert EUR to cents (assuming input is in EUR)
            $maxPriceInCents = (float) $maxPrice * 100;
            $query->where('price_amount', '<=', $maxPriceInCents);
        }

        // Distance filter (simplified - would need user location for proper implementation)
        // For now, we'll just order by location_id as a placeholder
        // In a real implementation, you'd calculate distance based on user's coordinates
        $distance = $request->input('distance', 10);

        // Sorting
        $sort = $request->input('sort', 'relevant');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price_amount', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_amount', 'desc');
                break;
            case 'newest':
                $query->latest('published_at');
                break;
            default: // 'relevant'
                $query->latest('published_at');
                break;
        }

        $listings = $query->paginate(12)->withQueryString();
        $listingCount = Listing::where('status', 'published')->count();
        $lastUpdated = Listing::latest('updated_at')->value('updated_at');

        return view('pages.explore', compact('categories', 'listings', 'listingCount', 'lastUpdated'));
    }
}
