<?php

namespace App\Admin\Customer\Infrastructure\Persistence;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MySqlCustomerRepository implements CustomerRepository
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = EloquentCustomerModel::query();
    }

    public function getBuilder(): Builder
    {
        return $this->builder->clone();
    }

    public function saveOrUpdate(Customer $customer): void
    {
        $db = $this->builder->where('id', '=', $customer->getId())->first();

        if (!$db) {
            $this->builder->insert($customer->toPrimitives());
            return;
        }

        $db->update($customer->toPrimitives());
    }

    public function searchById(string $id): ?Customer
    {
        $result = $this->getBuilder()->where('id', '=', $id)->first();

        if ($result === null) {
            return null;
        }

        return Customer::fromPrimitives($result->toArray());
    }

    public function searchByName(string $name): ?Customer
    {
        $result = $this->getBuilder()->where('name', '=', $name)->first();

        if ($result === null) {
            return null;
        }

        return Customer::fromPrimitives($result->toArray());
    }
}
