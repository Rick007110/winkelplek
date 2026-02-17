<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Listing;
use App\Models\Location;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MarketplaceRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $listing = $this->createListing();
        $user = $listing->user;

        $this->get(route('home'))->assertOk();
        $this->get(route('explore'))->assertOk();
        $this->get(route('listing.show', ['listing' => $listing->slug]))->assertOk();
        $this->get(route('profile.show', ['user' => $user->id]))->assertOk();
    }

    public function test_guest_is_redirected_from_protected_pages(): void
    {
        $listing = $this->createListing();
        $conversation = $this->createConversation($listing);
        $order = $this->createOrder($listing);

        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('listing.create'))->assertRedirect(route('login'));
        $this->get(route('favorites.index'))->assertRedirect(route('login'));
        $this->get(route('inbox.index'))->assertRedirect(route('login'));
        $this->get(route('inbox.show', ['conversation' => $conversation->id]))->assertRedirect(route('login'));
        $this->get(route('orders.index'))->assertRedirect(route('login'));
        $this->get(route('orders.show', ['order' => $order->id]))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_open_protected_pages(): void
    {
        $listing = $this->createListing();
        $conversation = $this->createConversation($listing);
        $order = $this->createOrder($listing);

        $this->actingAs($listing->user);

        $this->get(route('dashboard'))->assertOk();
        $this->get(route('listing.create'))->assertOk();
        $this->get(route('favorites.index'))->assertOk();
        $this->get(route('inbox.index'))->assertOk();
        $this->get(route('inbox.show', ['conversation' => $conversation->id]))->assertOk();
        $this->get(route('orders.index'))->assertOk();
        $this->get(route('orders.show', ['order' => $order->id]))->assertOk();
    }

    private function createListing(): Listing
    {
        $location = Location::create([
            'city' => 'Utrecht',
            'region' => 'Utrecht',
            'country_code' => 'NL',
            'postal_code' => '3511',
            'latitude' => 52.092876,
            'longitude' => 5.104480,
        ]);

        $category = Category::create([
            'name' => 'Elektronica',
            'slug' => 'elektronica',
            'sort_order' => 1,
        ]);

        $user = User::factory()->create();

        Profile::create([
            'user_id' => $user->id,
            'location_id' => $location->id,
            'display_name' => $user->name,
            'bio' => 'Test profiel',
            'rating_average' => 4.8,
            'rating_count' => 5,
        ]);

        return Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'location_id' => $location->id,
            'title' => 'Test listing',
            'slug' => Str::slug('Test listing'),
            'description' => 'Test listing description',
            'price_amount' => 12000,
            'currency' => 'EUR',
            'condition' => 'used',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);
    }

    private function createConversation(Listing $listing): Conversation
    {
        $buyer = User::factory()->create();

        return Conversation::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $listing->user_id,
            'status' => 'open',
            'last_message_at' => now(),
        ]);
    }

    private function createOrder(Listing $listing): Order
    {
        $buyer = User::factory()->create();

        return Order::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $listing->user_id,
            'amount' => 12000,
            'currency' => 'EUR',
            'status' => 'pending',
        ]);
    }
}
