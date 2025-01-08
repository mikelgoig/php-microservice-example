<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Query\List;

use App\Catalog\Domain\Model\Book\BookRepository;
use App\Shared\Application\Bus\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class ListBooksQueryHandler
{
    public function __construct(
        private BookRepository $books,
    ) {
    }

    public function __invoke(ListBooksQuery $query): BookRepository
    {
        $books = $this->books;

        if ($query->offset !== null && $query->limit !== null) {
            $books = $books->withPagination($query->offset, $query->limit);
        }

        return $books;
    }
}
