<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Delete;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Book\Application\Delete\DeleteBookCommand;
use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<BookResource, void>
 */
final readonly class DeleteBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): void {
        $bookId = $uriVariables['id'];
        \assert($bookId instanceof Uuid);
        $this->commandBus->dispatch(new DeleteBookCommand($bookId->toString()));
    }
}
