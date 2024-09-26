<?php

namespace App\Admin\Customer\Infrastructure\Repository;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use Illuminate\Support\Facades\DB;

class MySqlCustomerRepository implements CustomerRepository
{
    public function saveOrUpdate(Customer $customer): void
    {
        DB::table('customers')
            ->updateOrCreate($customer->toPrimitives());
    }
}
