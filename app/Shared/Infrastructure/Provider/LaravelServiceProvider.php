<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Provider;


use App\Shared\Domain\Service\Bus\Command\CommandBus;
use App\Shared\Domain\Service\Bus\Command\LaravelCommandBus;
use App\Shared\Domain\Service\Bus\Query\LaravelQueryBus;
use App\Shared\Domain\Service\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Service\HttpClient\AppHttpClient;
use App\Shared\Infrastructure\Service\HttpClient\HttpClient;
use App\Shared\Infrastructure\Service\Logger\AppLogger;
use App\Shared\Infrastructure\Service\Logger\Logger;
use App\Shared\Infrastructure\Service\Storage\Implementations\R2StorageImplementation;
use App\Shared\Infrastructure\Service\Storage\Storage;
use Illuminate\Support\Facades\File;

class LaravelServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        $this->registerSharedServiceProvider();

        foreach ($this->resolveProviders() as $provider) {
            $provider::create($this->app)->register();
        }
    }

    private function registerSharedServiceProvider(): void
    {
        $this->app->singleton(LaravelCommandBus::class, CommandBus::class);
        $this->app->singleton(LaravelQueryBus::class, QueryBus::class);
        $this->app->singleton(Logger::class, AppLogger::class);
        $this->app->singleton(HttpClient::class, AppHttpClient::class);
        $this->app->singleton(Storage::class, R2StorageImplementation::class);
    }

    private function resolveProviders(): iterable
    {
        $result = [];
        $baseNamespace = 'App\\';
        $basePath = app_path();
        $directories = File::directories($basePath);

        foreach ($directories as $directory) {
            $namespace = $baseNamespace . '\\' . basename($directory) . '\\Infrastructure';
            $providerClass = $namespace . '\\LaravelServiceProvider';
            if (!class_exists($providerClass)) {
                continue;
            }

            $result[] = $providerClass;
        }

        return $result;
    }
}
