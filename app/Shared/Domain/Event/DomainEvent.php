<?php

namespace App\Shared\Domain\Event;

use DateTimeImmutable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    abstract public static function create(array $payload, DateTimeImmutable $occurredOn): static;
}
