<?php

declare(strict_types=1);

namespace App\Admin\Customer\Domain\Event;

use App\Shared\Domain\ValueObject\UuidValueObject;
use DateTimeImmutable;
use DateTimeInterface;

readonly class CustomerCreatedEvent
{
    private string $id;
    private string $aggregateRootId;
    private DateTimeInterface $ocurredOn;

    public function __construct(
        string            $aggregateRootId,
        DateTimeInterface $ocurredOn = null,
    )
    {
        $this->id = UuidValueObject::generate()->value();
        $this->aggregateRootId = $aggregateRootId;
        $this->ocurredOn = $ocurredOn ?? new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function getOcurredOn(): DateTimeInterface
    {
        return $this->ocurredOn;
    }

    public function eventName(): string
    {
        return 'app.customer.created';
    }
}
