<?php

namespace App\Shared\Infrastructure\Configuration\ServiceProvider;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Foundation\Application;

abstract class AbstractServiceProvider extends ServiceProvider
{
    public static function create(Application $app): self
    {
        return new static($app);
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

    abstract protected function mapQueries(): void;
    abstract protected function mapCommands(): void;
    abstract protected function mapEvents(): void;
    abstract protected function mapServices(): void;
}
