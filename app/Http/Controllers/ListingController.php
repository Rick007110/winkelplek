<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function show(Listing $listing): View
    {
        return view('pages.listings.show', ['listing' => $listing]);
    }

    public function create(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('pages.listings.create', ['categories' => $categories]);
    }
}
