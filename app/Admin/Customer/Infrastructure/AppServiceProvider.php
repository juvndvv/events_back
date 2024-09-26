<?php

namespace App\Admin\Customer\Infrastructure;

use App\Admin\Customer\Domain\Port\CustomerRepository;
use App\Admin\Customer\Infrastructure\Repository\MySqlCustomerRepository;
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
        $this->app->bind(CustomerRepository::class, MySqlCustomerRepository::class);
    }
}
