<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Ecotone;

use App\Catalog\Book\Domain\Book;
use App\Catalog\Book\Domain\BookId;
use Ecotone\Modelling\Attribute\Repository;

interface EventSourcedBookRepository
{
    #[Repository]
    public function save(Book $book): void;

    #[Repository]
    public function findBy(BookId $bookId): ?Book;
}
