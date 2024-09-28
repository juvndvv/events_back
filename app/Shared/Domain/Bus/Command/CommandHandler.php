<?php

namespace App\Shared\Domain\Bus\Command;

use App\Shared\Application\Response;

abstract class CommandHandler
{
    abstract public function __invoke(Command $command): Response;
}
