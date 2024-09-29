<?php

namespace App\Admin\Customer\Domain\Service;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;

class NewCustomerValidator
{
    private array $errors = [];

    public function __construct(
        private readonly CustomerRepository $repository,
    )
    {
    }

    public function validate(Customer $customer): array
    {
        $nameSearch = $this->repository->searchByName($customer->getName());

        if ($nameSearch) {
            $this->errors[] = [ 'name' => 'name already exists' ];
        }

        return $this->errors;
    }
}
