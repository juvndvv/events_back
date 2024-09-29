<?php

namespace App\Admin\User\Application\Activate;

class ActivateUserCommand
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}
