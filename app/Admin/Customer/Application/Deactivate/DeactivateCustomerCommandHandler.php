<?php

namespace App\Admin\Customer\Application\Deactivate;

use App\Admin\Customer\Application\Activate\ActivateCustomerCommand;
use App\Admin\Customer\Application\Service\CustomerFinder;
use App\Admin\Customer\Domain\Exception\CustomerDoesNotExist;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use App\Shared\Domain\Bus\Command\CommandHandler;

class DeactivateCustomerCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CustomerFinder     $finder,
        private readonly CustomerRepository $repository,
    )
    {
    }

    public function __invoke(DeactivateCustomerCommand $command): void
    {
        $customer = $this->finder->searchById($command->id);

        if (null === $customer) {
            throw new CustomerDoesNotExist($command->id);
        }

        $customer->deactivate();
        $this->repository->saveOrUpdate($customer);
    }
}
