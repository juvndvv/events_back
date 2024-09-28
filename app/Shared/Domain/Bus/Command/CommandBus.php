<?php

namespace App\Shared\Domain\Bus\Command;

use App\Shared\Application\Response;

interface CommandBus
{
    public function dispatch($command);
    public function map(array $map): void;
}
