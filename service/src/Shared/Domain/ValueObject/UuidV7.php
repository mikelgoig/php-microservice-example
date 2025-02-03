<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\UuidV7 as SymfonyUuidV7;
use Webmozart\Assert\InvalidArgumentException;

abstract readonly class UuidV7 implements \Stringable
{
    final protected function __construct(
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

    final public static function random(): static
    {
        return new static(SymfonyUuidV7::generate());
    }

    final public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    private function ensureThatUuidIsValid(string $uuid): void
    {
        if (!SymfonyUuidV7::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $uuid));
        }
    }
}
