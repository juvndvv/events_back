<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Bus\Command\LaravelCommandBus;
use App\Shared\Infrastructure\Bus\Query\LaravelQueryBus;
use App\Shared\Infrastructure\Configuration\ServiceProvider\AbstractServiceProvider;
use App\Shared\Infrastructure\Services\RequesterInfo\HttpRequestMetadata;
use App\Shared\Infrastructure\Services\RequesterInfo\LaravelHttpRequestMetadata;

class AppServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->getServiceContainer()->bind(CommandBus::class, LaravelCommandBus::class);
        $this->getServiceContainer()->bind(QueryBus::class, LaravelQueryBus::class);
        $this->getServiceContainer()->bind(HttpRequestMetadata::class, LaravelHttpRequestMetadata::class);
    }

    /**
     * @return void
     */
    protected function mapQueries(): void
    {
    }

    /**
     * @return void
     */
    protected function mapCommands(): void
    {
    }

    /**
     * @return void
     */
    protected function mapEvents(): void
    {
    }

    /**
     * @return void
     */
    protected function mapServices(): void
    {
    }
}
