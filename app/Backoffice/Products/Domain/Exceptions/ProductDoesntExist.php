<?php

namespace App\Backoffice\Products\Domain\Exceptions;

use Throwable;

class ProductDoesntExist extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
