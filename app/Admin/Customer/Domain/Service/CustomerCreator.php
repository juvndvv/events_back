<?php

namespace App\Admin\Customer\Domain\Service;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use App\Shared\Domain\Exceptions\ValidationException;

class CustomerCreator
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly NewCustomerValidator $newCustomerValidator,
    )
    {
    }

    public function create(string $name): Customer
    {
        $customer = Customer::create(
            name: $name,
        );

        $errors = $this->newCustomerValidator->validate($customer);

        if (count($errors) > 0) {
            throw new ValidationException($errors, 'Customer validation failed');
        }

        $this->customerRepository->saveOrUpdate($customer);

        return $customer;
    }
}
