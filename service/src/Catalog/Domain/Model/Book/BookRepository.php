<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

interface BookRepository
{
    public function save(Book $book): void;

    public function ofId(BookId $id): ?Book;
}
