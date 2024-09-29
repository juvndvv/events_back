<?php

namespace App\Admin\User\Infrastructure\Entrypoint\Http;

use App\Admin\User\Application\Create\CreateUserCommand;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Shared\Infrastructure\Http\PostController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostUserController extends PostController
{
    public function __invoke(string $customerId, Request $request): JsonResponse
    {
        try {
            $command = new CreateUserCommand(
                $customerId,
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            );

            $result = $this->bus->dispatch($command);

            return $this->success(data: $result->response(), message: 'User created succesfully');

        } catch (ValidationException $exception) {
            return $this->unprocessableEntity($exception->getErrors());
        }

    }
}
