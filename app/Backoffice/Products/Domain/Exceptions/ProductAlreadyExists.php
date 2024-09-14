<?php

namespace App\Backoffice\Products\Domain\Exceptions;

use Exception;
use Throwable;

class ProductAlreadyExists extends Exception
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = "Product with id {$id} already exists.";
        parent::__construct($message, $code, $previous);
    }
}
