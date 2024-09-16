<?php

namespace App\Shared\Domain\Event;

class PusherEventBus implements EventBus
{
    public function publish(DomainEvent ...$event): void
    {
        foreach (func_get_args() as $event) {
            event($event);
        }
    }
}
