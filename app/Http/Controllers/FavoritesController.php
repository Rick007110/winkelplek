<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\View\View;

class FavoritesController extends Controller
{
    public function index(): View
    {
        $favorites = auth()->user()?->favoriteListings()->with('location')->get() ?? collect();

        return view('pages.favorites.index', ['favorites' => $favorites]);
    }
}
