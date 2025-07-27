<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $cartItemCount = 0;
            if (auth()->check()) {
                $cart = Cart::where('customer_id', auth()->id())->first();
                $cartItemCount = $cart ? $cart->items->sum('quantity') : 0;
            }

            $categories =Category::orderBy('name')->get();

            $view->with([
                'cartItemCount' => $cartItemCount,
                'categories' => $categories
            ]);
        });

    }
}
