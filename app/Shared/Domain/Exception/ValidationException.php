<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;


class ValidationException extends \Exception
{
    private array $errorList = [];

    public function __construct(array $errorList, $message = "validation_exception")
    {
        foreach ($errorList as $key => $error) {
            if ($message == "validation_exception" && !empty($error)) {
                $message = $error[0];
            }

            break;
        }

        parent::__construct($message, $cod = 0, $previous = null);

        $this->errorList = $errorList;
    }

    public function getErrorList(): iterable
    {
        return $this->errorList;
    }
}
