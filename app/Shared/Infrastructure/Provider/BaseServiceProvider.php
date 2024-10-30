<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Provider;

use App\Shared\Domain\Service\Bus\Command\CommandBus;
use App\Shared\Domain\Service\Bus\Query\QueryBus;
use Illuminate\Foundation\Application;

abstract class BaseServiceProvider implements ServiceProvider
{
    private function __construct(private readonly Application $app)
    {
    }

    public static function create(Application $app): self
    {
        return new static($app);
    }

    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->mapQueries();
        $this->mapCommands();
        $this->mapEvents();
        $this->mapServices();
    }

    protected function getQueryBus(): QueryBus
    {
        return $this->app->get(QueryBus::class);
    }

    protected function getCommandBus(): CommandBus
    {
        return $this->app->get(CommandBus::class);
    }

    protected function getServiceContainer(): Application
    {
        return $this->app;
    }

    protected function mapQueries(): void
    {
    }

    protected function mapCommands(): void
    {
    }

    protected function mapEvents(): void
    {
    }

    protected function mapServices(): void
    {
    }
}
