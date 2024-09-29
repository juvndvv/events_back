<?php

namespace App\Admin\User\Application\Find;

use App\Admin\User\Domain\User;

class FindUserResponse
{
    private array $response;

    public function __construct(
        private readonly User $user,
    )
    {
        $this->buildResponse();
    }

    public function response(): array
    {
        return $this->response;
    }

    private function buildResponse(): void
    {
        $this->response = $this->user->toPrimitives();
    }
}
