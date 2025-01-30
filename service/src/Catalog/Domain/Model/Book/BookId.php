<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use App\Shared\Domain\ValueObject\UuidV7;
use EventSauce\EventSourcing\AggregateRootId;

final readonly class BookId extends UuidV7 implements AggregateRootId
{
    public function toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new self($aggregateRootId);
    }
}
