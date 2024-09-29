<?php

namespace App\Admin\Customer\Application\Find;

use App\Admin\Customer\Application\Service\CustomerFinder;
use App\Admin\Customer\Domain\Exception\CustomerDoesNotExist;
use App\Shared\Domain\Bus\Query\QueryHandler;

class FindCustomerQueryHandler extends QueryHandler
{
    public function __construct(
        private readonly CustomerFinder $customerFinder
    )
    {
    }

    public function __invoke(FindCustomerQuery $query): FindCustomerResponse
    {
        $customer = $this->customerFinder->searchById($query->id);

        if (null === $customer) {
            throw new CustomerDoesNotExist($query->id);
        }

        return new FindCustomerResponse($customer);
    }
}
