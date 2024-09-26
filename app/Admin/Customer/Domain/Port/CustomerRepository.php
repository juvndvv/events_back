<?php

namespace App\Admin\Customer\Domain\Port;

use App\Admin\Customer\Domain\Customer;

interface CustomerRepository
{
    public function saveOrUpdate(Customer $customer): void;
}
