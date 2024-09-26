<?php

namespace App\Admin\Customer\Domain\Service;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;

class CustomerCreator
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    )
    {
    }

    public function create(string $name): Customer
    {
        $customer = Customer::create(
            name: $name,
        );

        $this->customerRepository->saveOrUpdate($customer);

        return $customer;
    }
}
