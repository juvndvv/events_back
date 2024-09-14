<?php

namespace App\Backoffice\User\Domain\Services;

use App\Backoffice\User\Domain\Exception\DuplicatedUserEmail;
use App\Backoffice\User\Domain\Exception\InvalidPassword;
use App\Backoffice\User\Domain\Exception\UserAlreadyExist;
use App\Backoffice\User\Domain\Port\UserRepository;
use App\Backoffice\User\Domain\User;
use App\Backoffice\User\Domain\ValueObject\UserEmail;
use App\Backoffice\User\Domain\ValueObject\UserHashPassword;
use App\Backoffice\User\Domain\ValueObject\UserName;

class UserCreator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFinder $userFinder,
        private readonly PasswordValidator $passwordValidator
    )
    {
    }

    public function __invoke(UserName $name, UserEmail $email, string $password): ?User
    {
        $hashedPass = $this->validateAndHash($password);

        $user = User::create(
            name: $name,
            email: $email,
            password: $hashedPass
        );

        $this->ensureUserDoesntExists($user);

        $this->userRepository->save($user);

        return $user;
    }

    private function validateAndHash(string $password): UserHashPassword
    {
        $result = $this->passwordValidator->validateAndHash($password);

        if (false === $result['success']) {
            throw new InvalidPassword($result['errors']);
        }

        return UserHashPassword::create($result['hash']);
    }

    public function ensureUserDoesntExists(User $user): void
    {
        $result = $this->userFinder->findById($user->getId());

        if (null !== $result) {
            throw new UserAlreadyExist($user->getId());
        }

        $result = $this->userFinder->findByEmail($user->getEmail());

        if (null !== $result) {
            throw new DuplicatedUserEmail($user->getEmail());
        }
    }
}
