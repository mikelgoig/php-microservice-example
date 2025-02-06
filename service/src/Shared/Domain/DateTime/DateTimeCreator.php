<?php

declare(strict_types=1);

namespace App\Shared\Domain\DateTime;

/**
 * Creates a new DateTimeImmutable object.
 */
final readonly class DateTimeCreator
{
    public static function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(timezone: new \DateTimeZone('UTC'));
    }

    public static function fromString(string $date): \DateTimeImmutable
    {
        try {
            return new \DateTimeImmutable($date);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
