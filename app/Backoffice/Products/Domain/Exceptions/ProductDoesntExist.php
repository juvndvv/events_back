<?php

namespace App\Backoffice\Products\Domain\Exceptions;

use Throwable;

class ProductDoesntExist extends \Exception
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = "Product doesn't exist: {$id}";
        parent::__construct($message, $code, $previous);
    }
}
