<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid as SymfonyUuid;
use Webmozart\Assert\InvalidArgumentException;

/** @phpstan-consistent-constructor */
abstract readonly class Uuid implements \Stringable
{
    protected function __construct(
        public string $value,
    ) {
        $this->ensureThatUuidIsValid($value);
    }

    final public function __toString(): string
    {
        return $this->value;
    }

    final public static function fromString(string $uuid): static
    {
        return new static($uuid);
    }

    final public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    private function ensureThatUuidIsValid(string $uuid): void
    {
        if (!SymfonyUuid::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $uuid));
        }
    }
}
