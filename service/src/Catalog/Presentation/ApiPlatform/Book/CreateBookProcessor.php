<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Application\Book\Command\Create\CreateBookCommand;
use App\Catalog\Application\Book\Query\Get\GetBookQuery;
use App\Shared\Application\Bus\Command\CommandBus;
use App\Shared\Application\Bus\Query\QueryBus;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

/**
 * @implements<BookResource, BookResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        \assert($data instanceof BookResource);
        Assert::notNull($data->name);

        $bookId = Uuid::v7();
        $this->commandBus->dispatch(new CreateBookCommand($bookId->toString(), $data->name));

        $book = $this->queryBus->ask(new GetBookQuery($bookId->toString()));
        return BookResource::fromModel($book);
    }
}
