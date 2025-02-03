<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Create;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookAlreadyExistsException;
use App\Catalog\Domain\Model\Book\BookChecker;
use App\Catalog\Domain\Model\Book\BookReadModelRepository;
use App\Catalog\Domain\Model\Book\BookRepository;
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
        $book = Book::create($command->id, $command->name);
        $this->books->save($book);
    }
}
