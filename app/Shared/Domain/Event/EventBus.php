<?php

namespace App\Shared\Domain\Event;

interface EventBus
{
    public function send(DomainEvent ...$event): void;
}
