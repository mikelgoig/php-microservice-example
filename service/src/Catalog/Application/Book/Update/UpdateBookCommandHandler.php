<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Update;

use App\Catalog\Domain\Model\Book\BookAlreadyExistsException;
use App\Catalog\Domain\Model\Book\BookChecker;
use App\Catalog\Domain\Model\Book\BookId;
use App\Catalog\Domain\Model\Book\BookReadModelRepository;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
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
