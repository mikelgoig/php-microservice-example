<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone;

use App\Shared\Application\Bus\Query\Query;
use App\Shared\Application\Bus\Query\QueryBus;
use Ecotone\Modelling\QueryBus as BaseEcotoneQueryBus;

final readonly class EcotoneQueryBus implements QueryBus
{
    public function __construct(
        private BaseEcotoneQueryBus $queryBus,
    ) {}

    public function ask(Query $query): mixed
    {
        return $this->queryBus->send($query);
    }
}
