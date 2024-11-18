<?php

declare(strict_types=1);

namespace App\Admin\Customer\Domain;

use App\Admin\Customer\Domain\Domain\CustomerId;
use App\Admin\Customer\Domain\Domain\CustomerName;
use App\Admin\Customer\Domain\Event\CustomerCreatedEvent;
use App\Shared\Domain\AggregateRoot;

class Customer extends AggregateRoot
{
    protected function __construct(
        private readonly CustomerId $id,
        private CustomerName        $name,
    )
    {
    }

    public function getId(): CustomerId
    {
        return $this->id;
    }

    public function getName(): CustomerName
    {
        return $this->name;
    }

    public function setName(CustomerName $name): void
    {
        $this->name = $name;
    }

    public static function create(
        CustomerId $id,
        CustomerName $name,
    ): self {
        $customer = new self($id, $name);

        $customer->record(new CustomerCreatedEvent($customer->getId()->value()));

        return $customer;
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
        ];
    }
}
