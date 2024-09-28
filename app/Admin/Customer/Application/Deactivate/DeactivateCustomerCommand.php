<?php

namespace App\Admin\Customer\Application\Deactivate;

use App\Shared\Domain\Bus\Command\Command;

class DeactivateCustomerCommand extends Command
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}
