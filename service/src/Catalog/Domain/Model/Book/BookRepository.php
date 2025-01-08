<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Book>
 */
interface BookRepository extends RepositoryInterface
{
    public function save(Book $book): void;

    public function ofId(string $id): ?Book;
}
