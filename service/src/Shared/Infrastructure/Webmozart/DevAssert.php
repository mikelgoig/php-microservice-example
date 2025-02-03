<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Webmozart;

use Webmozart\Assert\Assert;

final class DevAssert extends Assert
{
    /**
     * This method ensures that reported exceptions result in a 500 status code by
     * not utilizing \Webmozart\Assert\InvalidArgumentException.
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new \InvalidArgumentException($message);
    }
}
