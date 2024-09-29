<?php

namespace App\Admin\User\Application\Create;

class CreateUserCommand
{
    public function __construct(
        public string $customerId,
        public string $name,
        public string $email,
        public string $password,
    )
    {
    }
}
