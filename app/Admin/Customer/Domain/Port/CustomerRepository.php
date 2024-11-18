<?php

declare(strict_types=1);

namespace App\Admin\Customer\Domain\Port;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Domain\CustomerId;
use App\Admin\Customer\Domain\OptionalCustomer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
    public function search(CustomerId $id): OptionalCustomer;
}
