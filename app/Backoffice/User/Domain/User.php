<?php

namespace App\Backoffice\User\Domain;

use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\User\Domain\Event\UserEmailUpdated;
use App\Backoffice\User\Domain\Event\UserNameUpdated;
use App\Backoffice\User\Domain\ValueObject\UserEmail;
use App\Backoffice\User\Domain\ValueObject\UserHashPassword;
use App\Backoffice\User\Domain\ValueObject\UserName;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Identifier\UserId;

class User extends AggregateRoot
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserHashPassword $password;

    protected function __construct(
        ?UserId $id,
        ?UserName $name,
        ?UserEmail $email,
        ?UserHashPassword $password
    )
    {
        !$id ?: $this->id = $id;
        !$name ?: $this->name = $name;
        !$email ?: $this->email = $email;
        !$password ?: $this->password = $password;
    }

    public function getId(): string
    {
        return $this->id->value();
    }

    public function getName(): string
    {
        return $this->name->value();
    }

    public function getEmail(): string
    {
        return $this->email->value();
    }

    public function getPassword(): string
    {
        return $this->password->value();
    }

    public function updateName(string $name): void
    {
        $this->name = UserName::create($name);
        $this->record(new UserNameUpdated());
    }

    public function updateEmail(string $email): void
    {
        $this->email = UserEmail::create($email);
        $this->record(new UserEmailUpdated());
    }

    public function updateHashPassword(string $hashPassword): void
    {
        $this->password = UserHashPassword::create($hashPassword);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
        ];
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            id: UserId::create($primitives['id']),
            name: UserName::create($primitives['name']),
            email: UserEmail::create($primitives['email']),
            password: UserHashPassword::create($primitives['password'])
        );
    }

    public static function create(
        UserName $name,
        UserEmail $email,
        UserHashPassword $password
    )
    {
        return new self(
            id: UserId::generate(),
            name: $name,
            email: $email,
            password: $password,
        );
    }
}
