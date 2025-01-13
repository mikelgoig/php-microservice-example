<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Application\Book\Query\Get\GetBookQuery;
use App\Shared\Application\Bus\Query\QueryBus;
use Symfony\Component\Uid\UuidV7;

/**
 * @implements ProviderInterface<BookResource>
 */
final readonly class GetBookProvider implements ProviderInterface
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $id = $uriVariables['id'];
        \assert($id instanceof UuidV7);

        $book = $this->queryBus->ask(new GetBookQuery($id->toString()));
        return BookResource::fromModel($book);
    }
}
