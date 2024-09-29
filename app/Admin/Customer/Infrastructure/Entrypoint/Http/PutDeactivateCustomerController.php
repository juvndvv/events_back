<?php

namespace App\Admin\Customer\Infrastructure\Entrypoint\Http;

use App\Admin\Customer\Application\Deactivate\DeactivateCustomerCommand;
use App\Admin\Customer\Domain\Exception\CustomerAlreadyDeactivated;
use App\Admin\Customer\Domain\Exception\CustomerDoesNotExist;
use App\Shared\Infrastructure\Http\PutController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class PutDeactivateCustomerController extends PutController
{
    public function __invoke(string $id): JsonResponse
    {
        try {
            $command = new DeactivateCustomerCommand($id);

            $this->bus->dispatch($command);

            return $this->success(message: 'Customer deactivated successfully.');

        } catch (CustomerDoesNotExist $e) {
            return $this->badRequest($e->getMessage());

        } catch (CustomerAlreadyDeactivated $e) {
            return $this->badRequest($e->getMessage());

        } catch (Exception) {
            return $this->internalServerError();
        }
    }
}
