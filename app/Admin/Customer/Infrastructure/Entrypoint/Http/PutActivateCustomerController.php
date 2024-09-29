<?php

namespace App\Admin\Customer\Infrastructure\Entrypoint\Http;

use App\Admin\Customer\Application\Activate\ActivateCustomerCommand;
use App\Admin\Customer\Domain\Exception\CustomerAlreadyActive;
use App\Admin\Customer\Domain\Exception\CustomerDoesNotExist;
use App\Shared\Infrastructure\Http\PutController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class PutActivateCustomerController extends PutController
{
    public function __invoke(string $id): JsonResponse
    {
        try {
            $command = new ActivateCustomerCommand($id);

            $this->bus->dispatch($command);

            return $this->success(message: 'Customer activated successfully.');

        } catch (CustomerDoesNotExist $e) {
            return $this->badRequest($e->getMessage());

        } catch (CustomerAlreadyActive $e) {
            return $this->badRequest($e->getMessage());

        } catch (Exception $exception) {
            throw $exception;
            return $this->internalServerError();
        }
    }
}
