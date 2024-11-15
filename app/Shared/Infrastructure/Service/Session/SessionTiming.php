<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Session;

use App\Shared\Domain\Exception\LogicException;
use DateTimeImmutable;

class SessionTiming
{
    private string $id;
    private string $ipAddress;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $requestStartTime = null;
    private ?DateTimeImmutable $requestEndTime = null;
    private ?float $requestDuration = null;
    private ?float $queryDuration = null;
    private ?float $executionDuration = null;
    private ?string $endpoint = null;

    public function __construct()
    {
        $this->id = uniqid('', true) . '-' . bin2hex(random_bytes(5));
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setRequestStartTime(): void
    {
        $this->requestStartTime = new DateTimeImmutable();
    }

    public function setRequestEndTime(): void
    {
        $this->requestEndTime = new DateTimeImmutable();
        if ($this->requestStartTime !== null) {
            $this->requestDuration = $this->requestEndTime->getTimestamp() - $this->requestStartTime->getTimestamp();
        }
    }

    public function setQueryDuration(float $queryDuration): void
    {
        if (null === $this->requestDuration) {
            throw new LogicException('Request duration cannot be null.');
        }

        $this->queryDuration = $queryDuration;
        $this->executionDuration = $this->requestDuration - $this->queryDuration;
    }

    public function getRequestDuration(): ?float
    {
        return $this->requestDuration;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function getRequestStartTime(): ?DateTimeImmutable
    {
        return $this->requestStartTime;
    }

    public function getRequestEndTime(): ?DateTimeImmutable
    {
        return $this->requestEndTime;
    }

    public function getRequestDurarion(): float
    {
        return $this->requestDuration;
    }

    public function getQueryDuration(): ?int
    {
        return $this->queryDuration;
    }

    public function getExecutionDuration(): ?float
    {
        return $this->executionDuration;
    }

    public function __toString(): string
    {
        return sprintf(
            "Session ID: %s\nIP Address: %s\nCreated At: %s\nRequest Start Time: %s\nRequest End Time: %s\nRequest Duration: %s seconds\nEndpoint: %s",
            $this->id,
            $this->ipAddress ?? 'N/A',
            $this->createdAt->format('Y-m-d H:i:s'),
            $this->requestStartTime ? $this->requestStartTime->format('Y-m-d H:i:s') : 'N/A',
            $this->requestEndTime ? $this->requestEndTime->format('Y-m-d H:i:s') : 'N/A',
            $this->requestDuration !== null ? (string) $this->requestDuration : 'N/A',
            $this->endpoint ?? 'N/A'
        );
    }
}
