<?php

namespace App\Admin\Customer\Application\Create;

use App\Shared\Domain\Bus\Command\Command;

class CreateCustomerCommand extends Command
{
    public function __construct(
        public readonly string $name,
    )
    {
    }
}
