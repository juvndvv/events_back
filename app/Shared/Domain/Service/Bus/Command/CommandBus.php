<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service\Bus\Command;

interface CommandBus
{
    public function dispatch($command): void;
    public function map(array $map): void;
}
