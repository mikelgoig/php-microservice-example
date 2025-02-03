<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Update;

use App\Catalog\Domain\Model\Book\BookId;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class UpdateBookCommandHandler
{
    public function __construct(
        private BookRepository $books,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    #[CommandHandler]
    public function __invoke(UpdateBookCommand $command): void
    {
        $bookId = BookId::fromString($command->id);
        $book = $this->books->ofId($bookId) ?? throw CouldNotFindBookException::withId($command->id);
        $book->update($command->name);
        $this->books->save($book);
    }
}
