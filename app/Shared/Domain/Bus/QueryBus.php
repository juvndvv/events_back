<?php

namespace App\Shared\Domain\Bus;

interface QueryBus
{
    public function ask($query);
}
