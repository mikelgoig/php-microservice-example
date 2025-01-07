<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Application\Book\Query\Get\GetBookQuery;
use App\Shared\Application\Bus\Query\QueryBus;
use Webmozart\Assert\Assert;

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
        Assert::string($id);

        $book = $this->queryBus->ask(new GetBookQuery($id));
        return BookResource::fromModel($book);
    }
}
