<?php

namespace App\Admin\User\Infrastructure\Entrypoint\Http;

use App\Admin\User\Application\Find\FindUserQuery;
use App\Admin\User\Domain\Exception\UserDoesntExist;
use App\Shared\Infrastructure\Http\GetController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserController extends GetController
{
    public function __invoke(string $id): JsonResponse
    {
        try {
            $query = new FindUserQuery($id);
            $result = $this->queryBus->ask($query);

            return $this->success(data: $result->response(), message: 'Usuario encontrado');

        } catch (UserDoesntExist $e) {
            return $this->badRequest($e->getMessage());

        } catch (Exception) {
            return $this->internalServerError();
        }
    }
}
