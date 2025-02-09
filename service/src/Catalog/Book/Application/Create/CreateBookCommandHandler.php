<?php

declare(strict_types=1);

namespace App\Catalog\Book\Application\Create;

use App\Catalog\Book\Domain\Book;
use App\Catalog\Book\Domain\BookAlreadyExistsException;
use App\Catalog\Book\Domain\BookChecker;
use App\Catalog\Book\Domain\BookReadModelRepository;
use App\Catalog\Book\Domain\BookRepository;
use Ecotone\Modelling\Attribute\CommandHandler;

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
     * @throws BookAlreadyExistsException
     */
    #[CommandHandler]
    public function __invoke(CreateBookCommand $command): void
    {
        $this->bookChecker->ensureThatThereIsNoBookWithName($command->name);
        $book = Book::create($command->id, $command->name, $command->description, $command->tags);
        $this->books->save($book);
    }
}
