<?php

namespace App\Admin\User\Domain\Service\Validator\NewUserValidator;


use App\Admin\User\Domain\Service\Validator\UserValidator;

class NewUserValidator
{
    private array $chain = [];
    private array $bag = [];

    public function __construct(
        ValidateIsUniqueUser $validateIsUniqueUser,
        PasswordValidator $passwordValidator,
    )
    {
        $this->chain[] = $validateIsUniqueUser;
        $this->chain[] = $passwordValidator;
    }

    public function validate(string $customerId, string $name, string $email, string $password): void
    {
        foreach ($this->chain as $validator /** @var UserValidator $validator */) {
            $validator->validate($customerId, $name, $email, $password, $this->bag);
        }
    }

    public function hasErrors(): bool
    {
        return count($this->bag) > 0;
    }

    public function getErrors(): array
    {
        return $this->bag;
    }
}
