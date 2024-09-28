<?php

namespace App\Admin\Customer\Domain\Service;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;

class CustomerFinder
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    )
    {
    }

    public function searchById(string $id): ?Customer
    {
        return $this->customerRepository->searchById($id);
    }
}
