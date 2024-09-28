<?php

namespace App\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query);
    public function map(array $map): void;
}
