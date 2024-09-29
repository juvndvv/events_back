<?php

namespace App\Shared\Domain\Bus\Command;


interface CommandBus
{
    public function dispatch($command);
    public function map(array $map): void;
}
