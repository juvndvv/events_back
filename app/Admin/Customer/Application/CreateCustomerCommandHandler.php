<?php

namespace App\Admin\Customer\Application;

use App\Admin\Customer\Domain\Service\CustomerCreator;

class CreateCustomerCommandHandler
{
    public function __construct(
        private readonly CustomerCreator $customerCreator
    )
    {
    }

    public function __invoke(CreateCustomerCommand $command): void
    {
        $this->customerCreator->create(
            name: $command->name
        );
    }
}
