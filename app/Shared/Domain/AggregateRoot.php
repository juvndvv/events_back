<?php

namespace App\Shared\Domain;

class AggregateRoot
{
    protected array $events = [];

    public function pullDomainEvents(): array
    {
        return array_splice($this->events, 0);
    }

    public function record($event): void
    {
        $this->events[] = $event;
    }
}
