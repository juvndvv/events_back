<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Exception;

use Exception;
use Throwable;

class OutOfStock extends Exception
{
    public function __construct(int $available, int $quantity, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('Cannot use %s item/s, %s available', $quantity, $available);
        parent::__construct($message, $code, $previous);
    }
}
