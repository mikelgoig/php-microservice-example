<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Query\Get;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Shared\Application\Bus\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetBookQueryHandler
{
    public function __construct(
        private BookRepository $books,
    ) {
    }

    public function __invoke(GetBookQuery $query): Book
    {
        $book = $this->books->ofId($query->id);

        if ($book === null) {
            throw new \RuntimeException('Book not found');
        }

        return $book;
    }
}
