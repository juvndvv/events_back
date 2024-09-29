<?php

namespace App\Admin\User\Application\Create;

use App\Admin\User\Domain\User;

class CreateUserResponse
{
    private array $response;

    public function __construct(
        private readonly string $id
    )
    {
        $this->buildResponse();
    }

    public function response(): array
    {
        return $this->response;
    }

    private function buildResponse()
    {
        $this->response = ['id' => $this->id];
    }
}
