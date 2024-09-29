<?php

namespace App\Admin\User\Domain\Service\Validator\NewUserValidator;

use App\Admin\User\Application\Service\UserFinder;
use App\Admin\User\Domain\Service\Validator\UserValidator;

class ValidateIsUniqueUser implements UserValidator
{
    public function __construct(
        private readonly UserFinder $userFinder,
    )
    {
    }

    public function validate(string $customerId, string $name, string $email, string $password, array &$bag): void
    {

        $result = $this->userFinder->findByEmail($email);

        if (null !== $result) {
            $bag['email'] = 'El email ya existe';
        }
    }
}
