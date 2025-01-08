<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @template T of object
 * @implements RepositoryInterface<T>
 */
abstract class DoctrineRepository implements RepositoryInterface
{
    private ?int $offset = null;
    private ?int $limit = null;

    private QueryBuilder $queryBuilder;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        string $entityClass,
        string $alias,
    ) {
        $this->queryBuilder = $this->entityManager->createQueryBuilder()
            ->select($alias)
            ->from($entityClass, $alias);
    }

    public function paginator(): ?PaginatorInterface
    {
        $firstResult = $this->offset;
        $maxResults = $this->limit;

        if ($firstResult === null || $maxResults === null) {
            return null;
        }

        $repository = $this->filter(static function (QueryBuilder $qb) use ($firstResult, $maxResults) {
            $qb->setFirstResult($firstResult)->setMaxResults($maxResults);
        });

        /** @var Paginator<T> $paginator */
        $paginator = new Paginator($repository->queryBuilder->getQuery());

        return new DoctrinePaginator($paginator);
    }

    public function withPagination(int $offset, int $limit): static
    {
        $cloned = clone $this;
        $cloned->offset = $offset;
        $cloned->limit = $limit;
        return $cloned;
    }

    public function withoutPagination(): static
    {
        $cloned = clone $this;
        $cloned->offset = null;
        $cloned->limit = null;
        return $cloned;
    }

    public function getIterator(): \Iterator
    {
        $paginator = $this->paginator();
        if ($paginator !== null) {
            yield from $paginator;
            return;
        }

        yield from $this->queryBuilder->getQuery()->getResult();
    }

    public function count(): int
    {
        $paginator = $this->paginator() ?? new Paginator(clone $this->queryBuilder);
        return count($paginator);
    }

    protected function __clone()
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }

    /**
     * @return static<T>
     */
    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder);
        return $cloned;
    }
}
