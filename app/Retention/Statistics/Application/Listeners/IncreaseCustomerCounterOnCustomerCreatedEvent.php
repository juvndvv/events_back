<?php

declare(strict_types=1);

namespace App\Retention\Statistics\Application\Listeners;


use App\Admin\Customer\Application\Services\CustomerFinder;
use App\Admin\Customer\Domain\Event\CustomerCreatedEvent;

class IncreaseCustomerCounterOnCustomerCreatedEvent
{
    public function __construct(
        private readonly CustomerFinder $customerFinder,
    )
    {
    }

    public function __invoke(CustomerCreatedEvent $event): void
    {
        $customer = $this->customerFinder->searchById($event->getAggregateRootId());

        if (null === $customer) {
            throw CustomerNotF
        }
    }
}
