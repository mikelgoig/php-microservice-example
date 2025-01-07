<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus\Query;

interface QueryBus
{
    /**
     * @template T
     * @param Query<T> $query
     * @return T
     */
    public function ask(Query $query): mixed;
}
