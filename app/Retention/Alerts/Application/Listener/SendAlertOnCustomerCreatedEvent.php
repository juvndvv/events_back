<?php

declare(strict_types=1);

namespace App\Retention\Alerts\Application\Listener;


use App\Admin\Customer\Application\Services\CustomerFinder;
use App\Admin\Customer\Domain\Event\CustomerCreatedEvent;

readonly class SendAlertOnCustomerCreatedEvent
{
    public function __construct(
        private CustomerFinder $finder,
    )
    {
    }

    public function __invoke(CustomerCreatedEvent $event): void
    {
        $customer = $this->finder->searchById($event->getAggregateRootId());

        // TODO send alert to slack
    }
}
