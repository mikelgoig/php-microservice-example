<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

use App\Shared\Domain\Exception\DomainException;

final class BookAlreadyExistsException extends DomainException
{
    public static function withName(string $name): self
    {
        return new self("Book with name <\"{$name}\"> already exists.");
    }
}
