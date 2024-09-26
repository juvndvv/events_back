<?php

namespace App\Admin\Customer\Application;

class CreateCustomerCommand
{
    public function __construct(
        public readonly string $name,
    )
    {
    }
}
