<?php

namespace App\Admin\Customer\Infrastructure\Entrypoint\Http;

use App\Admin\Customer\Application\Create\CreateCustomerCommand;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Shared\Infrastructure\Http\PostController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostCustomerController extends PostController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $name = $request->string('name');

            $command = new CreateCustomerCommand(
                name: $name
            );

            $response = $this->bus->dispatch($command);

            return $this->created($response->response(), 'Customer created successfully');

        } catch (ValidationException $exception) {
            return $this->unprocessableEntity($exception->getErrors(), $exception->getMessage());

        } catch (\Exception $exception) {
            return $this->internalServerError($exception->getMessage());
        }
    }
}
