<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service\Bus\Command;

use Illuminate\Bus\Dispatcher;

final class LaravelCommandBus implements CommandBus
{
    public function __construct(
        private readonly Dispatcher $bus
    ) {
    }

    public function dispatch($command): void
    {
        $this->bus->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
