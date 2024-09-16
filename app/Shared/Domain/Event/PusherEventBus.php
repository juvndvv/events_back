<?php

namespace App\Shared\Domain\Event;

class PusherEventBus implements EventBus
{

    public function send(DomainEvent ...$event): void
    {
        foreach (func_get_args() as $event) {
            event($event);
        }
    }
}
