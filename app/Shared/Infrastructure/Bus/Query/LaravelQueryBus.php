<?php

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use Illuminate\Bus\Dispatcher;

class LaravelQueryBus implements QueryBus
{
    public function __construct(private readonly Dispatcher $bus)
    {
    }

    public function ask(Query $query)
    {
        return $this->bus->dispatchSync($query);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
