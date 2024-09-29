<?php

namespace App\Admin\Customer\Domain\Exception;

use Exception;
use Throwable;

class CustomerDoesNotExist extends Exception
{   public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
{
    $message = sprintf('Customer with id "%s" can not be found.', $id);
    parent::__construct($message, $code, $previous);
}
}
