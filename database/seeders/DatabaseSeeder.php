<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\Profile;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $locations = collect([
            Location::create([
                'city' => 'Utrecht',
                'region' => 'Utrecht',
                'country_code' => 'NL',
                'postal_code' => '3511',
                'latitude' => 52.092876,
                'longitude' => 5.104480,
            ]),
            Location::create([
                'city' => 'Rotterdam',
                'region' => 'Zuid-Holland',
                'country_code' => 'NL',
                'postal_code' => '3011',
                'latitude' => 51.924420,
                'longitude' => 4.477733,
            ]),
        ]);

        $categories = collect([
            ['name' => 'Fietsen en brommers', 'slug' => 'fietsen-en-brommers'],
            ['name' => 'Auto`s en onderdelen', 'slug' => 'autos-en-onderdelen'],
            ['name' => 'Huis en inrichting', 'slug' => 'huis-en-inrichting'],
            ['name' => 'Elektronica', 'slug' => 'elektronica'],
            ['name' => 'Kleding en accessoires', 'slug' => 'kleding-en-accessoires'],
            ['name' => 'Kinderen en baby`s', 'slug' => 'kinderen-en-babys'],
            ['name' => 'Sport en hobby', 'slug' => 'sport-en-hobby'],
            ['name' => 'Zakelijke goederen', 'slug' => 'zakelijke-goederen'],
            ['name' => 'Diensten en vakmensen', 'slug' => 'diensten-en-vakmensen'],
        ])->map(function (array $category, int $index) {
            return Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'sort_order' => $index + 1,
            ]);
        });

        $sanne = User::create([
            'name' => 'Sanne de Vries',
            'email' => 'sanne@winkelplek.nl',
            'password' => Hash::make('password'),
        ]);

        $milan = User::create([
            'name' => 'Milan van Dijk',
            'email' => 'milan@winkelplek.nl',
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'user_id' => $sanne->id,
            'location_id' => $locations[1]->id,
            'display_name' => 'Sanne de Vries',
            'bio' => 'Verkoop meubels en woonaccessoires. Snelle reacties en duidelijke afspraken.',
            'rating_average' => 4.9,
            'rating_count' => 42,
        ]);

        Profile::create([
            'user_id' => $milan->id,
            'location_id' => $locations[0]->id,
            'display_name' => 'Milan van Dijk',
            'bio' => 'Elektronica en audio in nette staat. Afhalen of verzenden in overleg.',
            'rating_average' => 4.8,
            'rating_count' => 31,
        ]);

        $listings = collect([
            [
                'title' => 'Gazelle CityGo 7 versnellingen',
                'description' => 'Stadsfiets in goede staat, recent onderhoud gehad. Inclusief slot en standaard.',
                'price_amount' => 18500,
                'category' => 'fietsen-en-brommers',
                'location' => $locations[0],
                'user' => $milan,
            ],
            [
                'title' => 'Eikenhouten bureau 120 cm',
                'description' => 'Massief eiken bureau met lade, lichte gebruikssporen. Ophalen in Rotterdam.',
                'price_amount' => 24000,
                'category' => 'huis-en-inrichting',
                'location' => $locations[1],
                'user' => $sanne,
            ],
        ])->map(function (array $listing) use ($categories) {
            $category = $categories->firstWhere('slug', $listing['category']);

            return Listing::create([
                'user_id' => $listing['user']->id,
                'category_id' => $category?->id,
                'location_id' => $listing['location']->id,
                'title' => $listing['title'],
                'slug' => Str::slug($listing['title']),
                'description' => $listing['description'],
                'price_amount' => $listing['price_amount'],
                'currency' => 'EUR',
                'condition' => 'used',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
            ]);
        });
    }
}
