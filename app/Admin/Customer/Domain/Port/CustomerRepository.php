<?php

namespace App\Admin\Customer\Domain\Port;

use App\Admin\Customer\Domain\Customer;

interface CustomerRepository
{
    public function searchById(string $id): ?Customer;

    public function searchByName(string $name): ?Customer;
    public function saveOrUpdate(Customer $customer): void;
}
