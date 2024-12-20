<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Create;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Shared\Application\Bus\Command\AsCommandHandler;

#[AsCommandHandler]
final readonly class CreateBookCommandHandler
{
    public function __construct(
        private BookRepository $books,
    ) {
    }

    public function __invoke(CreateBookCommand $command): void
    {
        $book = Book::create($command->id, $command->name);
        $this->books->save($book);
    }
}
