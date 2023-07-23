<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Room;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();
        // Paginator::useBootstrap();

        $page_data = Page::where('id', 1)->first();
        $room_data = Room::all();
        view()->share('global_page_data', $page_data);
        view()->share('global_room_data', $room_data);


    }
}