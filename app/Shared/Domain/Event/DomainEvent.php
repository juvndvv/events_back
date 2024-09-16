<?php

namespace App\Shared\Domain\Event;

use DateTimeImmutable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class DomainEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public DateTimeImmutable $ocurredOn;

    public function __construct(
        string $eventName,
        ?DateTimeImmutable $occurredOn = null,
    )
    {
        $this->ocurredOn = $occurredOn ?? new DateTimeImmutable();
    }

    public function broadcastOn(): array
    {
        return ['events'];
    }

    public function broadcastAs(): string
    {
        return $this->name();
    }

    public function name(): string
    {
        return static::$eventName;
    }
}
