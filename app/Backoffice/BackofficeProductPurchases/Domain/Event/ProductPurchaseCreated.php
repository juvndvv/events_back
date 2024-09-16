<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

class ProductPurchaseCreated extends DomainEvent
{
    static string $eventName = ProductPurchaseCreated::class;

    public function __construct(
        public string $id,
        ?DateTimeImmutable $occurredOn = null)
    {
        parent::__construct(self::$eventName, $occurredOn);
    }
}
