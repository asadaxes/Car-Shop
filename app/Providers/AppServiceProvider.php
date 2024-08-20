<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Brands;
use App\Models\Pages;
use App\Models\Settings;
use App\Models\VehiclesCategory;
use App\Models\Pna_Orders;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $brands = Brands::all();
            $pages = Pages::orderBy('id', 'desc')->get();
            $settings = Settings::first();
            $vehicle_categories = VehiclesCategory::all();
            $incomplete_orders = Pna_Orders::whereIn('deliver_status', ['preparing', 'on_the_way'])->where('status', 'success')->distinct('order_id')->count('order_id');
            $view->with(['brands' => $brands, 'vehicle_categories' => $vehicle_categories, 'incomplete_orders' => $incomplete_orders, 'pages' => $pages, 'settings' => $settings]);
        });
    }
}