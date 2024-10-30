<?php

declare(strict_types=1);


namespace App\Shared\Domain\Service\Bus\Query;

use Illuminate\Bus\Dispatcher;

final class LaravelQueryBus implements QueryBus
{
    public function __construct(private readonly Dispatcher $bus)
    {
    }

    public function ask($query)
    {
        return $this->bus->dispatchSync($query);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
