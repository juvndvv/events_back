<?php

namespace App\Backoffice\Products\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

class ProductCreatedEvent extends DomainEvent
{
    public function __construct(
        private readonly array $payload,
        private readonly DateTimeImmutable $occurredOn
    )
    {
    }

    public static function create(array $payload, DateTimeImmutable $occurredOn): static
    {
        // TODO: Implement create() method.
    }
}
