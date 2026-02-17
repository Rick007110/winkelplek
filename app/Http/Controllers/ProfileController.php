<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->loadMissing([
            'profile.location',
            'listings' => fn ($query) => $query->where('status', 'published')->latest('published_at'),
        ]);

        return view('pages.profiles.show', ['user' => $user]);
    }
}
