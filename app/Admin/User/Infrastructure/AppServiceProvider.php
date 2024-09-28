<?php

namespace App\Admin\User\Infrastructure;

use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Infrastructure\Repository\MySqlUserRepository;
use App\Shared\Infrastructure\Configuration\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{

    protected function mapQueries(): void
    {
        // TODO: Implement mapQueries() method.
    }

    protected function mapCommands(): void
    {
        // TODO: Implement mapCommands() method.
    }

    protected function mapEvents(): void
    {
        // TODO: Implement mapEvents() method.
    }

    protected function mapServices(): void
    {
        $this->getServiceContainer()->bind(UserRepository::class, MySqlUserRepository::class);
    }
}
