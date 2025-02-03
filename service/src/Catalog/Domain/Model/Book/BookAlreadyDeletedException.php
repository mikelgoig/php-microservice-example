<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use App\Shared\Domain\Exception\DomainException;

final class BookAlreadyDeletedException extends DomainException
{
    public static function withId(BookId $id): self
    {
        return new self("Book <\"{$id}\"> is already deleted.");
    }
}
