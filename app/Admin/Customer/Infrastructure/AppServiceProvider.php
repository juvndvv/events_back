<?php

namespace App\Admin\Customer\Infrastructure;

use App\Admin\Customer\Application\Activate\ActivateCustomerCommand;
use App\Admin\Customer\Application\Activate\ActivateCustomerCommandHandler;
use App\Admin\Customer\Application\Create\CreateCustomerCommand;
use App\Admin\Customer\Application\Create\CreateCustomerCommandHandler;
use App\Admin\Customer\Application\Deactivate\DeactivateCustomerCommand;
use App\Admin\Customer\Application\Deactivate\DeactivateCustomerCommandHandler;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use App\Admin\Customer\Infrastructure\Persistence\MySqlCustomerRepository;
use App\Shared\Infrastructure\Configuration\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->getServiceContainer()->bind(CustomerRepository::class, MySqlCustomerRepository::class);
    }

    protected function mapQueries(): void
    {
    }

    protected function mapCommands(): void
    {
        $this->getCommandBus()->map([
            CreateCustomerCommand::class => CreateCustomerCommandHandler::class,
            ActivateCustomerCommand::class => ActivateCustomerCommandHandler::class,
            DeactivateCustomerCommand::class => DeactivateCustomerCommandHandler::class,
        ]);
    }

    protected function mapEvents(): void
    {
    }

    protected function mapServices(): void
    {
    }
}
