<?php

namespace App\Admin\Customer\Application\Activate;

use App\Admin\Customer\Application\Deactivate\DeactivateCustomerCommand;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use App\Admin\Customer\Domain\Service\CustomerFinder;
use App\Shared\Domain\Bus\Command\CommandHandler;

class ActivateCustomerCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CustomerFinder $finder,
        private readonly CustomerRepository $repository,
    )
    {
    }

    public function __invoke(DeactivateCustomerCommand $command): void
    {
        $customer = $this->finder->searchById($command->id);
        $customer->activate();
        $this->repository->saveOrUpdate($customer);
    }
}
