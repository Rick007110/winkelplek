<?php

use App\Http\Controllers\ExploreController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Listing;
use App\Models\Order;
use App\Models\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::orderBy('sort_order')->take(12)->get();
    $featuredListings = Listing::with('location')
        ->where('status', 'published')
        ->latest('published_at')
        ->take(4)
        ->get();
    $listingCount = Listing::count();
    $categoryCount = Category::count();
    $ratingAverage = Profile::avg('rating_average');

    return view('welcome', compact('categories', 'featuredListings', 'listingCount', 'categoryCount', 'ratingAverage'));
})->name('home');

Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/listing/{listing:slug}', [ListingController::class, 'show'])->name('listing.show');
Route::get('/profiles/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/listing/create', [ListingController::class, 'create'])->name('listing.create');
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/{conversation}', [InboxController::class, 'show'])->name('inbox.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::get('dashboard', function () {
    $user = auth()->user();
    $listingCount = Listing::where('user_id', $user->id)->count();
    $favoriteCount = $user->favoriteListings()->count();
    $orderCount = Order::where('buyer_id', $user->id)->orWhere('seller_id', $user->id)->count();
    $conversationCount = Conversation::where('buyer_id', $user->id)->orWhere('seller_id', $user->id)->count();

    return view('dashboard', compact('listingCount', 'favoriteCount', 'orderCount', 'conversationCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
