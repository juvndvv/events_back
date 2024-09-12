<?php

namespace App\Shared\Domain\Bus\Event;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;

abstract class DomainEventSubscriber implements ShouldQueue
{
    public string $connection = 'redis';
    public string $queue = 'default';

    abstract public function handle(): void;

    abstract public function subscribeTo(): array;

    public function subscribe(): void
    {
        foreach ($this->subscribeTo() as $event) {
            Event::subscribe($event);
        }
    }
}
