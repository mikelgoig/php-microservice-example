<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

/**
 * @template T of object
 * @extends \IteratorAggregate<array-key, T>
 */
interface RepositoryInterface extends \IteratorAggregate, \Countable
{
    /**
     * @return PaginatorInterface<T>|null
     */
    public function paginator(): ?PaginatorInterface;

    /**
     * @return static<T>
     */
    public function withPagination(int $offset, int $limit): static;

    /**
     * @return static<T>
     */
    public function withoutPagination(): static;
}
