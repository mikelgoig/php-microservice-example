<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Application\Book\Query\List\ListBooksQuery;
use App\Shared\Application\Bus\Query\QueryBus;

/**
 * @implements ProviderInterface<BookResource>
 */
final readonly class ListBooksProvider implements ProviderInterface
{
    public function __construct(
        private QueryBus $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * @return PaginatorInterface<BookResource>|list<BookResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): PaginatorInterface|array
    {
        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getOffset($operation, $context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        $models = $this->queryBus->ask(new ListBooksQuery($offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = BookResource::fromModel($model);
        }

        $paginator = $models->paginator();
        if ($paginator !== null) {
            $resources = new TraversablePaginator(
                new \ArrayIterator($resources),
                (float) $paginator->currentPage(),
                (float) $paginator->itemsPerPage(),
                (float) $paginator->totalItems(),
            );
        }

        return $resources;
    }
}
