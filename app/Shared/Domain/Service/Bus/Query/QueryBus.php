<?php

namespace App\Shared\Domain\Service\Bus\Query;

interface QueryBus
{
    public function ask($query);
    public function map(array $map): void;
}
