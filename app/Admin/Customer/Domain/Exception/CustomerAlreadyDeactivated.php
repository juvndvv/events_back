<?php

namespace App\Admin\Customer\Domain\Exception;

use App\Admin\Customer\Domain\Customer;
use Throwable;

class CustomerAlreadyDeactivated extends \Exception
{
    public function __construct(Customer $customer, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('Customer already deactivated: [%s] %s', $customer->getId(), $customer->getName());
        parent::__construct($message, $code, $previous);    }
}
