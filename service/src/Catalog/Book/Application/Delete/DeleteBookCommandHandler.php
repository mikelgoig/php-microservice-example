<?php

declare(strict_types=1);

namespace App\Catalog\Book\Application\Delete;

use App\Catalog\Book\Domain\BookId;
use App\Catalog\Book\Domain\BookRepository;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class DeleteBookCommandHandler
{
    public function __construct(
        private BookRepository $books,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    #[CommandHandler]
    public function __invoke(DeleteBookCommand $command): void
    {
        $bookId = BookId::fromString($command->id);
        $book = $this->books->ofId($bookId) ?? throw CouldNotFindBookException::withId($bookId);
        $book->delete();
        $this->books->save($book);
    }
}
