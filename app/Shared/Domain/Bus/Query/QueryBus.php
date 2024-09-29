<?php

namespace App\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function ask($query);
    public function map(array $map): void;
}
