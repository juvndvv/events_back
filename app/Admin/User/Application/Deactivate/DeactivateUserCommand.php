<?php

namespace App\Admin\User\Application\Deactivate;

class DeactivateUserCommand
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}
