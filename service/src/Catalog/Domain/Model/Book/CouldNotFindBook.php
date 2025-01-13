<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use App\Shared\Domain\Exception\DomainException;

final class CouldNotFindBook extends DomainException
{
    public static function withId(string $id): self
    {
        return new self("Could not find book <{$id}>.");
    }
}
