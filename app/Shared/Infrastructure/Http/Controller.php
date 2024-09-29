<?php

namespace App\Shared\Infrastructure\Http;


use App\Shared\Infrastructure\Services\RequesterInfo\HttpRequestMetadata;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public function __construct(
        protected HttpRequestMetadata $httpRequestMetadata
    )
    {
    }

    protected function success(
        $data = [],
        $message = '',
    ): JsonResponse {
        return new JsonResponse(
            data: [ 'message' => $message, 'data' => $data],
            status: Response::HTTP_OK,
        );
    }

    protected function created(array $data = [], string $message = ''): JsonResponse
    {
        return new JsonResponse(
            data: [ 'message' => $message, 'data' => $data],
            status: Response::HTTP_CREATED,
        );
    }

    protected function badRequest(string $message = ''): JsonResponse
    {
        return new JsonResponse(
            data: [ 'message' => $message],
            status: Response::HTTP_BAD_REQUEST,
        );
    }

    protected function unprocessableEntity(array $errors = [], string $message = ''): JsonResponse
    {
        return new JsonResponse(
            data: [ 'message' => $message, 'errors' => $errors],
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

    protected function internalServerError(?string $message = null): JsonResponse
    {
        return new JsonResponse(
            data: [ 'message' => $message ?? 'An error occurred while processing your request.'],
            status: Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}
