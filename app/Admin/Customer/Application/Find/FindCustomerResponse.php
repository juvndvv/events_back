<?php

namespace App\Admin\Customer\Application\Find;

use App\Admin\Customer\Domain\Customer;
use App\Shared\Application\Response;

class FindCustomerResponse extends Response
{
    public function __construct(
        private readonly Customer $customer,
    )
    {
    }

    public function response(): array
    {
        return $this->customer->toPrimitives();
    }
}
