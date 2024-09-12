<?php

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\Event\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
