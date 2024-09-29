<?php

namespace App\Admin\User\Domain\Service;

use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Domain\Service\Validator\NewUserValidator\NewUserValidator;
use App\Admin\User\Domain\User;
use App\Shared\Domain\Exceptions\ValidationException;

class UserCreator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly NewUserValidator $newUserValidator,
    )
    {
    }

    public function create(string $customerId, string $name, string $email, string $password): User
    {
        $this->newUserValidator->validate($customerId, $name, $email, $password);

        if ($this->newUserValidator->hasErrors()) {
            throw new ValidationException($this->newUserValidator->getErrors(), 'Ha ocurrido un error al crear el usuario');
        }

        $hashedPass = hash('sha256', $password);

        $user = User::create(
            name: $name,
            email: $email,
            password: $hashedPass,
            customerId: $customerId,
        );

        $this->userRepository->saveOrUpdate($user);

        return $user;
    }
}
