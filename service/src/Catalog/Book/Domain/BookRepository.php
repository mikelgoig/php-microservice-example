<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

interface BookRepository
{
    public function save(Book $book): void;

    public function ofId(BookId $id): ?Book;
}
