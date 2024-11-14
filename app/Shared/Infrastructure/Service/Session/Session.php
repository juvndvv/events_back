<?php

declare(strict_types=1);


namespace App\Shared\Infrastructure\Service\Session;

use DateTimeImmutable;

class Session
{
    private string $id;
    private string $ipAddress;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $requestStartTime = null;
    private ?DateTimeImmutable $requestEndTime = null;
    private ?float $requestDuration = null;
    private ?string $endpoint = null;
    private int $queriesExecuted = 0;
    private int $totalQueriesTime = 0;

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

    public function getQueriesExecuted(): int
    {
        return $this->queriesExecuted;
    }

    public function setQueriesExecuted(int $queriesExecuted): void
    {
        $this->queriesExecuted = $queriesExecuted;
    }

    public function getTotalQueryTime(): int
    {
        return $this->totalQueriesTime;
    }

    public function setTotalQueryTime(int $totalQueriesTime): void
    {
        $this->totalQueriesTime = $totalQueriesTime;
    }
}
