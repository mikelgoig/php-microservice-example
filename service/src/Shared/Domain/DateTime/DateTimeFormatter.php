<?php

declare(strict_types=1);

namespace App\Shared\Domain\DateTime;

/**
 * Returns date formatted as ATOM with UTC timezone.
 */
final readonly class DateTimeFormatter
{
    public static function toAtomUtcString(\DateTimeInterface $date = new \DateTimeImmutable()): string
    {
        return \DateTimeImmutable::createFromInterface($date)
            ->setTimezone(new \DateTimeZone('UTC'))
            ->format('Y-m-d\TH:i:s.u\Z');
    }
}
