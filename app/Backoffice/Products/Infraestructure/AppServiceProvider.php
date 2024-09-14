<?php

namespace App\Backoffice\Products\Infraestructure;

use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Infraestructure\Repository\MySqlProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductRepository::class, MySqlProductRepository::class);
    }
}
