<?php

namespace App\Admin\User\Domain\Exception;

use Throwable;

class InvalidPassword extends \Exception
{
    public function __construct(array $messages, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(json_encode($messages), $code, $previous);
    }
}
