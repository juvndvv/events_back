<?php

namespace App\Admin\Customer\Application\Create;

use App\Admin\Customer\Domain\Service\CustomerCreator;
use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Exceptions\InvalidArgumentException;

class CreateCustomerCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly CustomerCreator $customerCreator
    )
    {
    }

    public function __invoke(Command $command): CreateCustomerResponse
    {
        if (!$command instanceof CreateCustomerCommand) {
            throw new InvalidArgumentException('Invalid command type');
        }

        $customer = $this->customerCreator->create(
            $command->name
        );

        return new CreateCustomerResponse($customer->getId());
    }
}
