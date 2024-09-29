<?php

namespace App\Admin\User\Application\Create;

use App\Admin\User\Domain\Service\UserCreator;

class CreateUserCommandHandler
{
    public function __construct(
        private readonly UserCreator $creator
    )
    {
    }

    public function __invoke(CreateUserCommand $command): CreateUserResponse
    {
        $user = $this->creator->create($command->customerId, $command->name, $command->email, $command->password);

        return new CreateUserResponse($user->getId());
    }
}
