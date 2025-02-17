<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

final class CouldNotFindBookException extends \DomainException
{
    public static function withId(BookId $id): self
    {
        return new self("Could not find book <\"{$id}\">.");
    }
}
