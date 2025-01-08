<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Domain\Repository\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @template T of object
 * @implements PaginatorInterface<T>
 */
final readonly class DoctrinePaginator implements PaginatorInterface
{
    private int $firstResult;
    private int $maxResults;

    /**
     * @param Paginator<T> $paginator
     */
    public function __construct(
        private Paginator $paginator,
    ) {
        $firstResult = $paginator->getQuery()->getFirstResult();
        $maxResults = $paginator->getQuery()->getMaxResults();

        if ($maxResults === null) {
            throw new \InvalidArgumentException('Missing maxResults from the query.');
        }

        $this->firstResult = $firstResult;
        $this->maxResults = $maxResults;
    }

    public function currentPage(): int
    {
        if ($this->maxResults <= 0) {
            return 1;
        }

        return (int) (1 + floor($this->firstResult / $this->maxResults));
    }

    public function itemsPerPage(): int
    {
        return $this->maxResults;
    }

    public function lastPage(): int
    {
        if ($this->maxResults <= 0) {
            return 1;
        }

        return (int) (ceil($this->totalItems() / $this->maxResults) ?: 1);
    }

    public function totalItems(): int
    {
        return count($this->paginator);
    }

    public function getIterator(): \Traversable
    {
        return $this->paginator->getIterator();
    }

    public function count(): int
    {
        return iterator_count($this->getIterator());
    }
}
