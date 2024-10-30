<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;


use App\Shared\Domain\Exceptions\InvalidArgumentException;
use DateTime;
use DateTimeZone;

class DateTimeZoneValueObject
{
    private DateTime $dateTime;

    public function __construct(int $day, int $month, int $year, int $hours, int $minutes, int $seconds, string $timezone)
    {
        if (!in_array($timezone, DateTimeZone::listIdentifiers(), true)) {
            throw new InvalidArgumentException("Invalid timezone: {$timezone}");
        }

        $dateTimeString = sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hours, $minutes, $seconds);
        $this->dateTime = new DateTime($dateTimeString, new DateTimeZone($timezone));
    }

    public function toUtc(): string
    {
        $utcDateTime = clone $this->dateTime;
        $utcDateTime->setTimezone(new DateTimeZone('UTC'));

        return $utcDateTime->format('Y-m-d H:i:s');
    }

    public static function fromUtc(string $utcDateTimeString): self
    {
        $dateTime = new DateTime($utcDateTimeString, new DateTimeZone('UTC'));
        return self::createFromDateTime($dateTime);
    }

    public function toDateTime(): DateTime
    {
        return clone $this->dateTime;
    }

    public function convertToTimezone(string $newTimezone): DateTimeZoneValueObject
    {
        if (!in_array($newTimezone, DateTimeZone::listIdentifiers(), true)) {
            throw new InvalidArgumentException("Invalid timezone: {$newTimezone}");
        }

        $dateTime = clone $this->dateTime;
        $dateTime->setTimezone(new DateTimeZone($newTimezone));

        return self::createFromDateTime($dateTime);
    }

    public function __toString(): string
    {
        return $this->dateTime->format('Y-m-d H:i:s T');
    }

    public static function createFromDateTime(DateTime $dateTime): self
    {
        return new self(
            (int) $dateTime->format('d'),
            (int) $dateTime->format('m'),
            (int) $dateTime->format('Y'),
            (int) $dateTime->format('H'),
            (int) $dateTime->format('i'),
            (int) $dateTime->format('s'),
            $dateTime->getTimezone()->getName()
        );
    }

    public static function now(string $timezone = 'UTC'): self
    {
        if (!in_array($timezone, DateTimeZone::listIdentifiers(), true)) {
            throw new InvalidArgumentException("Invalid timezone: {$timezone}");
        }

        $dateTime = new DateTime('now', new DateTimeZone($timezone));
        return self::createFromDateTime($dateTime);
    }
}
