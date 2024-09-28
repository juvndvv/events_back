<?php

namespace App\Admin\Customer\Application\Activate;

use App\Shared\Domain\Bus\Command\Command;

class ActivateCustomerCommand extends Command
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}
