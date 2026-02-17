<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $orders = Order::with(['listing', 'buyer', 'seller'])
            ->when($user, fn ($query) => $query
                ->where('buyer_id', $user->id)
                ->orWhere('seller_id', $user->id))
            ->latest('created_at')
            ->get();

        return view('pages.orders.index', ['orders' => $orders]);
    }

    public function show(Order $order): View
    {
        $order->load(['listing', 'buyer', 'seller']);

        return view('pages.orders.show', ['order' => $order]);
    }
}
