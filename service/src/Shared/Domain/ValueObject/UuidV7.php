<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\UuidV7 as SymfonyUuidV7;
use Webmozart\Assert\InvalidArgumentException;

abstract readonly class UuidV7 extends Uuid
{
    final protected function __construct(string $value)
    {
        parent::__construct($value);
        $this->ensureThatUuidIsValid($value);
    }

    final public static function random(): static
    {
        return new static(SymfonyUuidV7::generate());
    }

    private function ensureThatUuidIsValid(string $uuid): void
    {
        if (!SymfonyUuidV7::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $uuid));
        }
    }
}
