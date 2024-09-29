<?php

namespace App\Admin\User\Domain\Service\Validator;

interface UserValidator
{
    public function validate(string $customerId, string $name, string $email, string $password, array &$bag): void;
}
