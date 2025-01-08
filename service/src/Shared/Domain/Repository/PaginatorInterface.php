<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

/**
 * @template T of object
 * @extends \IteratorAggregate<array-key, T>
 */
interface PaginatorInterface extends \IteratorAggregate, \Countable
{
    public function currentPage(): int;

    public function itemsPerPage(): int;

    public function lastPage(): int;

    public function totalItems(): int;
}
