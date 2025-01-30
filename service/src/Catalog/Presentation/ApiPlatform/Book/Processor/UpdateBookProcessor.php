<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Application\Book\Command\Update\UpdateBookCommand;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookCommandResource;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use App\Shared\Application\Bus\Command\CommandBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<BookCommandResource, BookQueryResource>
 */
final readonly class UpdateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): BookQueryResource {
        $bookId = $uriVariables['id'];
        \assert($bookId instanceof Uuid);

        $this->commandBus->dispatch(new UpdateBookCommand($bookId->toString(), $data->name));

        $book = $this->entityManager->find(BookQueryResource::class, $bookId->toString());
        \assert($book instanceof BookQueryResource, "Book with ID <\"{$bookId->toString()}\"> was not found.");
        return $book;
    }
}
