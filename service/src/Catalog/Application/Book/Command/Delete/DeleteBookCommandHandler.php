<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Delete;

use App\Catalog\Domain\Model\Book\BookAlreadyDeletedException;
use App\Catalog\Domain\Model\Book\BookId;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class DeleteBookCommandHandler
{
    public function __construct(
        private BookRepository $books,
    ) {}

    /**
     * @throws BookAlreadyDeletedException
     * @throws CouldNotFindBookException
     */
    #[CommandHandler]
    public function __invoke(DeleteBookCommand $command): void
    {
        $bookId = BookId::fromString($command->id);
        $book = $this->books->ofId($bookId) ?? throw CouldNotFindBookException::withId($command->id);
        $book->delete();
        $this->books->save($book);
    }
}
