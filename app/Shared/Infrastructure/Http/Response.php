<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;


class Response
{
    public function __construct(
        private readonly int $statusCode,
        private readonly array $data,
        private readonly string $message,
    ) {
    }

    public function toArray(): array
    {
        return [
            'status' => $this->statusCode,
            'data' => $this->data,
            'message' => $this->message,
        ];
    }

    public static function create(HttpStatus $status, array $data, string $message): array
    {
        return (new self($status->value, $data, $message))->toArray();
    }
}
