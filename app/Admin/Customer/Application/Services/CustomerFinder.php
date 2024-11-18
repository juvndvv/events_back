<?php

declare(strict_types=1);

namespace App\Admin\Customer\Application\Services;


use App\Admin\Customer\Domain\Domain\CustomerId;
use App\Admin\Customer\Domain\Port\CustomerRepository;

class CustomerFinder
{
    public function __construct(
        private readonly CustomerRepository $repository,
    )
    {
    }

    public function searchById(string $id): ?array
    {
        $id = CustomerId::create($id);
        $customer = $this->repository->search($id);

        return $customer->ifPresent(fn ($customer) => $customer->toPrimitives())->orElseNull();
    }
}
