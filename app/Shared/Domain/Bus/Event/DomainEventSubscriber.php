<?php

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\Event\DomainEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

abstract class DomainEventSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(DomainEvent $event): void
    {
        $this->on($event);
    }

    abstract public function on(DomainEvent $event): void;

    abstract public function subscribedTo(): string;
}
