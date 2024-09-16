<?php

namespace App\Shared\Domain\Event;

use DateTimeImmutable;

abstract class DomainEvent
{
    public readonly DateTimeImmutable $ocurredOn;

    public function __construct(
        string $eventName,
        ?DateTimeImmutable $occurredOn = null,
    )
    {
        $this->ocurredOn = $occurredOn ?? new DateTimeImmutable();
    }

    public function name(): string
    {
        return static::$eventName;
    }
}
