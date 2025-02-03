<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Ecotone\Repository;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookId;
use App\Catalog\Domain\Model\Book\BookRepository;

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
