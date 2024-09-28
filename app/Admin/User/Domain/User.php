<?php

namespace App\Admin\User\Domain;


use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Event\User\UserEmailUpdated;
use App\Shared\Domain\Event\User\UserNameUpdated;
use App\Shared\Domain\Identifier\UserId;
use App\Shared\Domain\ValueObject\BoolValueObject;
use App\Shared\Domain\ValueObject\Customer\CustomerId;
use App\Shared\Domain\ValueObject\User\UserEmail;
use App\Shared\Domain\ValueObject\User\UserHashPassword;
use App\Shared\Domain\ValueObject\User\UserName;

class User extends AggregateRoot
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserHashPassword $password;
    private CustomerId $customerId;
    private BoolValueObject $isActive;

    protected function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
        string $customerId
    )
    {
        $this->id = UserId::create($id);
        $this->name = UserName::create($name);
        $this->email = UserEmail::create($email);
        $this->password = UserHashPassword::create($password);
        $this->customerId = CustomerId::create($customerId);
        $this->isActive = BoolValueObject::create(false);
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

    public function getCustomerId(): string
    {
        return $this->customerId->value();
    }

    public function isActive(): bool
    {
        return $this->isActive->value();
    }

    public function isDeactivated(): bool
    {
        return !$this->isActive();
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
            id: $primitives['id'],
            name: $primitives['name'],
            email: $primitives['email'],
            password: $primitives['password'],
            customerId: $primitives['customerId'],
        );
    }

    public static function create(
        string $name,
        string $email,
        string $password,
        string $customerId,
    )
    {
        return new self(
            id: UserId::generate()->value(),
            name: $name,
            email: $email,
            password: $password,
            customerId: $customerId,
        );
    }
}
