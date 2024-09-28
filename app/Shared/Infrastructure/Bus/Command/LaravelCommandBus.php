<?php

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandBus;
use Illuminate\Bus\Dispatcher;

readonly class LaravelCommandBus implements CommandBus
{
    public function __construct(
        private Dispatcher $bus
    ) {
    }

    public function dispatch($command)
    {
        return $this->bus->dispatchSync($command);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
