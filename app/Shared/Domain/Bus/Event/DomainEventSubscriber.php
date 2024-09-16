<?php

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\Event\DomainEvent;

abstract class DomainEventSubscriber
{
    abstract public function on(DomainEvent $event): void;
    abstract public function subscribedTo(): string;
}
