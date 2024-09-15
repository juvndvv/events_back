<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Exception;

use Exception;

class PurchaseDoesntExist extends Exception
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = "Purchase doesn't exist: " . $id;
        parent::__construct($message, $code, $previous);
    }
}
