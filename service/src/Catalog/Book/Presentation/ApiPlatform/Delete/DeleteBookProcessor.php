<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Delete;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Book\Application\Delete\DeleteBookCommand;
use App\Catalog\Book\Presentation\ApiPlatform\BookFinder;
use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<BookResource, BookResource>
 */
final readonly class DeleteBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private BookFinder $bookFinder,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): BookResource {
        $bookId = $uriVariables['id'];
        \assert($bookId instanceof Uuid);
        $this->commandBus->dispatch(new DeleteBookCommand($bookId->toString()));
        return $this->bookFinder->find($bookId, $context);
    }
}
