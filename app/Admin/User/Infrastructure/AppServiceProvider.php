<?php

namespace App\Admin\User\Infrastructure;

use App\Admin\User\Application\Activate\ActivateUserCommand;
use App\Admin\User\Application\Activate\ActivateUserCommandHandler;
use App\Admin\User\Application\Create\CreateUserCommand;
use App\Admin\User\Application\Create\CreateUserCommandHandler;
use App\Admin\User\Application\Deactivate\DeactivateUserCommand;
use App\Admin\User\Application\Deactivate\DeactivateUserCommandHandler;
use App\Admin\User\Application\Find\FindUserQuery;
use App\Admin\User\Application\Find\FindUserQueryHandler;
use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Infrastructure\Persistence\MySqlUserRepository;
use App\Shared\Infrastructure\Configuration\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    protected function mapQueries(): void
    {
        $this->getQueryBus()->map([
            FindUserQuery::class => FindUserQueryHandler::class
        ]);
    }

    protected function mapCommands(): void
    {
        $this->getCommandBus()->map([
            CreateUserCommand::class => CreateUserCommandHandler::class,
            ActivateUserCommand::class => ActivateUserCommandHandler::class,
            DeactivateUserCommand::class => DeactivateUserCommandHandler::class,
        ]);
    }

    protected function mapEvents(): void
    {
    }

    protected function mapServices(): void
    {
        $this->getServiceContainer()->bind(UserRepository::class, MySqlUserRepository::class);
    }
}
