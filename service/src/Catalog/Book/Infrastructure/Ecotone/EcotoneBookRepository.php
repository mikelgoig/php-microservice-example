<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Ecotone;

use App\Catalog\Book\Domain\Book;
use App\Catalog\Book\Domain\BookId;
use App\Catalog\Book\Domain\BookRepository;

final readonly class EcotoneBookRepository implements BookRepository
{
    public function __construct(
        private EventSourcedBookRepository $eventSourcedRepository,
    ) {}

    public function save(Book $book): void
    {
        $this->eventSourcedRepository->save($book);
    }

    public function ofId(BookId $id): ?Book
    {
        $book = $this->eventSourcedRepository->findBy($id);

        if ($book === null) {
            return null;
        }

        if ($book->isDeleted()) {
            return null;
        }

        return $book;
    }
}
