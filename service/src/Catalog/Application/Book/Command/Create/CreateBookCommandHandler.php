<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Create;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookAlreadyExists;
use App\Catalog\Domain\Model\Book\BookChecker;
use App\Catalog\Domain\Model\Book\BookReadModelRepository;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Shared\Application\Bus\Command\AsCommandHandler;

#[AsCommandHandler]
final readonly class CreateBookCommandHandler
{
    private BookChecker $bookChecker;

    public function __construct(
        private BookRepository $books,
        BookReadModelRepository $bookReadModels,
    ) {
        $this->bookChecker = new BookChecker($bookReadModels);
    }

    /**
     * @throws BookAlreadyExists
     */
    public function __invoke(CreateBookCommand $command): void
    {
        $this->bookChecker->ensureThatThereIsNoBookWithName($command->name);
        $book = Book::create($command->id, $command->name);
        $this->books->save($book);
    }
}
