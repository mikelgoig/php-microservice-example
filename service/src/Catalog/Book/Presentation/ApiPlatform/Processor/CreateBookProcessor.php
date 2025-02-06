<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Book\Application\Create\CreateBookCommand;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<BookResource, BookResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private BookFinder $bookFinder,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): BookResource {
        $bookId = Uuid::v7();
        $this->commandBus->dispatch(new CreateBookCommand($bookId->toString(), $data->name));
        return $this->bookFinder->find($bookId, $context);
    }
}
