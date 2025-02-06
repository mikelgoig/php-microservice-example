<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Ecotone\Book;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookId;
use Ecotone\Modelling\Attribute\Repository;

interface EventSourcedBookRepository
{
    #[Repository]
    public function save(Book $book): void;

    #[Repository]
    public function findBy(BookId $bookId): ?Book;
}
