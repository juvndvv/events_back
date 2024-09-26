<?php

namespace App\Admin\Customer\Domain\Exception;

use App\Admin\Customer\Domain\Customer;
use Exception;
use Throwable;

class CustomerAlreadyActive extends Exception
{
    public function __construct(Customer $customer, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('Customer already active: [%s] %s', $customer->getId(), $customer->getName());
        parent::__construct($message, $code, $previous);
    }
}
