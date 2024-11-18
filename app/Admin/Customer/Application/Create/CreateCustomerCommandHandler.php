<?php

declare(strict_types=1);

namespace App\Admin\Customer\Application\Create;


use App\Admin\Customer\Domain\Domain\CustomerId;
use App\Admin\Customer\Domain\Domain\CustomerName;
use App\Admin\Customer\Domain\Service\CustomerCreator;
use App\Shared\Domain\Event\EventBus;
use App\Shared\Domain\Service\Validator\Validator;

class CreateCustomerCommandHandler
{
    public function __construct(
        private readonly Validator $validator,
        private readonly EventBus $eventBus,
        private readonly CustomerCreator $creator,
    )
    {
    }

    public function __invoke(CreateCustomerCommand $command): void
    {
        $this->validator->validateOrFail($command);
        
        $customer = $this->creator->__invoke(
            id: CustomerId::create($command->id),
            name: CustomerName::create($command->name),
        );

        $this->eventBus->publish(...$customer->pullDomainEvents());
    }
}
