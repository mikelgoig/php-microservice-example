<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Application\Book\Command\Delete\DeleteBookCommand;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookCommandResource;
use App\Shared\Application\Bus\Command\CommandBus;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<BookCommandResource, void>
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
