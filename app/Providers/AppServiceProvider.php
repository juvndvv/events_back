<?php

namespace App\Providers;

use App\Backoffice\BackofficeProductPurchases\Domain\Event\ProductPurchaseCreated;
use App\Backoffice\BackofficeProductPurchases\Domain\Port\BackofficeProductPurchaseRepository;
use App\Backoffice\BackofficeProductPurchases\Infrastructure\Repository\MySqlBackofficeProductPurchaseRepository;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Infraestructure\Repository\MySqlProductRepository;
use App\Backoffice\User\Domain\Port\UserRepository;
use App\Backoffice\User\Infrastructure\Repository\MySqlUserRepository;
use App\Retention\QRCode\Application\GenerateQR\GenerateQROnProductPurchaseCreated;
use App\Retention\QRCode\Domain\Port\QRCodeRepository;
use App\Retention\QRCode\Infrastructure\Repository\ChillerLanQRCodeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductPurchaseCreated::class => [
            GenerateQROnProductPurchaseCreated::class
        ]
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BackofficeProductPurchaseRepository::class, MySqlBackofficeProductPurchaseRepository::class);
        $this->app->bind(ProductRepository::class, MySqlProductRepository::class);
        $this->app->bind(UserRepository::class, MySqlUserRepository::class);
        $this->app->bind(QrCodeRepository::class, ChillerLanQRCodeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
