<?php

namespace App\Admin\Customer\Application\Create;

use App\Admin\Customer\Domain\Service\CustomerCreator;
use App\Shared\Domain\Bus\Command\CommandHandler;

class CreateCustomerCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CustomerCreator $customerCreator,
    )
    {
    }

    public function __invoke(CreateCustomerCommand $command): CreateCustomerResponse
    {
        $customer = $this->customerCreator->create(
            $command->name
        );

        return new CreateCustomerResponse($customer->getId());
    }
}
