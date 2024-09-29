<?php

namespace App\Admin\Customer\Domain;

use App\Admin\Customer\Domain\Exception\CustomerAlreadyActive;
use App\Admin\Customer\Domain\Exception\CustomerAlreadyDeactivated;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\BoolValueObject;
use App\Shared\Domain\ValueObject\Customer\CustomerId;
use App\Shared\Domain\ValueObject\Customer\CustomerName;

class Customer extends AggregateRoot
{
    private CustomerId $id;
    private CustomerName $name;
    private BoolValueObject $isActive;

    public function __construct(
        string $id,
        string $name,
        bool $active,
    )
    {
        $this->id = CustomerId::create($id);
        $this->name = CustomerName::create($name);
        $this->isActive = BoolValueObject::create($active);
    }

    public function getId(): string
    {
        return $this->id->value();
    }

    public function getName(): string
    {
        return $this->name->value();
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
        $this->name = CustomerName::create($name);
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new CustomerAlreadyActive($this);
        }

        $this->isActive = BoolValueObject::create(true);
    }

    public function deactivate(): void
    {
        if ($this->isDeactivated()) {
            throw new CustomerAlreadyDeactivated($this);
        }

        $this->isActive = BoolValueObject::create(false);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'active' => $this->isActive->value(),
        ];
    }

    public static function fromPrimitives(array $primitives): Customer
    {
        return new self(
            $primitives['id'],
            $primitives['name'],
            $primitives['active']
        );
    }

    public static function create(string $name): self
    {
        return new self(CustomerId::generate()->value(), $name, false);
    }
}
