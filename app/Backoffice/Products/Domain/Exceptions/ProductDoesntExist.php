<?php

namespace App\Backoffice\Products\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\ValueObject\ProductId;
use Throwable;

class ProductDoesntExist extends DomainException
{
    public function __construct(ProductId $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = "Product with id {$id->value()} does not exists.";
        parent::__construct($message, $code, $previous);
    }
}
