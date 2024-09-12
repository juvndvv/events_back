<?php

namespace App\Shared\Domain\Bus\Event\InMemory;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\Event\DomainEvent;
use Illuminate\Support\Facades\Event;

class InMemoryLaravelEventBus implements EventBus
{
    public function publish(DomainEvent ...$events): void
    {
        Event::dispatch(...$events);
    }
}
