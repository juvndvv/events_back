<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Provider;


use App\Shared\Domain\Service\Bus\Command\CommandBus;
use App\Shared\Domain\Service\Bus\Command\LaravelCommandBus;
use App\Shared\Domain\Service\Bus\Query\LaravelQueryBus;
use App\Shared\Domain\Service\Bus\Query\QueryBus;
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
