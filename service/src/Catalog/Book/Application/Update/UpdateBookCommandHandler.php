<?php

declare(strict_types=1);

namespace App\Catalog\Book\Application\Update;

use App\Catalog\Book\Domain\BookAlreadyExistsException;
use App\Catalog\Book\Domain\BookChecker;
use App\Catalog\Book\Domain\BookId;
use App\Catalog\Book\Domain\BookReadModelRepository;
use App\Catalog\Book\Domain\BookRepository;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class UpdateBookCommandHandler
{
    private BookChecker $bookChecker;

    public function __construct(
        private BookRepository $books,
        BookReadModelRepository $bookReadModels,
    ) {
        $this->bookChecker = new BookChecker($bookReadModels);
    }

    /**
     * @throws CouldNotFindBookException
     * @throws BookAlreadyExistsException
     */
    #[CommandHandler]
    public function __invoke(UpdateBookCommand $command): void
    {
        $bookId = BookId::fromString($command->id);
        $book = $this->books->ofId($bookId) ?? throw CouldNotFindBookException::withId($command->id);
        $this->bookChecker->ensureThatThereIsNoBookWithName($command->name, $bookId);
        $book->update($command->name);
        $this->books->save($book);
    }
}
