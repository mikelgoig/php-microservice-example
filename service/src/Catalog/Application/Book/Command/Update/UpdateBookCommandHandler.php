<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Update;

use App\Catalog\Domain\Model\Book\BookRepository;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Shared\Application\Bus\Command\AsCommandHandler;

#[AsCommandHandler]
final readonly class UpdateBookCommandHandler
{
    public function __construct(
        private BookRepository $books,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function __invoke(UpdateBookCommand $command): void
    {
        $book = $this->books->ofId($command->id);

        if ($book === null) {
            throw CouldNotFindBookException::withId($command->id);
        }

        $book->update($command->name);
        $this->books->save($book);
    }
}
