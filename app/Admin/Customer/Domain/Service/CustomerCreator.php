<?php

declare(strict_types=1);

namespace App\Admin\Customer\Domain\Service;


use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Domain\CustomerId;
use App\Admin\Customer\Domain\Domain\CustomerName;
use App\Admin\Customer\Domain\Port\CustomerRepository;

readonly class CustomerCreator
{
    public function __construct(
        private CustomerRepository $repository
    )
    {
    }

    public function __invoke(
        CustomerId $id,
        CustomerName $name,
    ): Customer {
        $customer = Customer::create(
            id: $id,
            name: $name,
        );

        $this->repository->save($customer);

        return $customer;
    }
}
