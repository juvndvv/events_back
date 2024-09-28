<?php

namespace App\Shared\Infrastructure\Services\RequesterInfo;

use App\Admin\Customer\Domain\Customer;
use App\Admin\Customer\Domain\Port\CustomerRepository;
use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Domain\User;
use LogicException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class LaravelHttpRequestMetadata implements HttpRequestMetadata
{
    private User $user;
    private Customer $customer;

    public function __construct(
        private readonly CustomerRepository $customerRepository
    )
    {
    }

    public function build(string $token): self
    {
        $user = $this->userRepository->searchByToken($token);
        $this->validateUserOrFail($user);

        $customer = $this->customerRepository->searchById($user->getCustomerId());
        $this->validateCustomerOrFail($customer);

        $this->user = $user;
        $this->customer = $customer;

        return $this;
    }

    public function getUserId(): string
    {
        $this->ensureIsBuilded();

        return $this->user->getId();
    }

    public function getCustomerId(): string
    {
        $this->ensureIsBuilded();

        return $this->customer->getId();
    }

    private function ensureIsBuilded(): void
    {
        if (!isset($this->user)) {
            throw new LogicException('User not builded');
        }
    }

    private function validateUserOrFail(?User $user): void
    {
        if (null === $user) {
            throw new LogicException('No se encuentra el usuario');
        }

        if ($user->isDeactivated()) {
            throw new LogicException('El usuario esta desactivado');
        }
    }

    private function validateCustomerOrFail(?Customer $customer): void
    {
        if (null === $customer) {
            throw new BadRequestException('No se encuentra el cliente');
        }

        if ($customer->isDeactivated()) {
            throw new BadRequestException('El cliente esta desactivado');
        }
    }
}
