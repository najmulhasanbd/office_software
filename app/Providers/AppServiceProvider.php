<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\Sales;

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
    public function boot(): void
    {
        Paginator::useBootstrap();

         // Retrieve monthly sales data
    $monthlySales = Sales::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
    ->whereYear('created_at', Carbon::now()->year) // Filter to only this year's sales
    ->groupBy('month')
    ->pluck('total', 'month')
    ->toArray();

// Ensure all 12 months are represented, even months with no sales
$monthlySales = array_replace(array_fill(1, 12, 0), $monthlySales);

// Share monthly sales data globally to all views
View::share('monthlySales', $monthlySales);
    }
}
