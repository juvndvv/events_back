<?php

namespace App\Backoffice\Products\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

class ProductCreated
{
    public function __construct(
    )
    {
    }

    public static function create(array $payload, DateTimeImmutable $occurredOn): static
    {
        // TODO: Implement create() method.
    }
}
