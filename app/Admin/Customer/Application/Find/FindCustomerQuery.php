<?php

namespace App\Admin\Customer\Application\Find;

use App\Shared\Domain\Bus\Query\Query;

class FindCustomerQuery extends Query
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}
