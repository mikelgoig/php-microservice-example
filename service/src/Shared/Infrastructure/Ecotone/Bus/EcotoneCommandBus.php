<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone\Bus;

use App\Shared\Application\Bus\Command;
use App\Shared\Application\Bus\CommandBus;
use Ecotone\Modelling\CommandBus as BaseEcotoneCommandBus;

final readonly class EcotoneCommandBus implements CommandBus
{
    public function __construct(
        private BaseEcotoneCommandBus $commandBus,
    ) {}

    public function dispatch(Command $command): void
    {
        $this->commandBus->send($command);
    }
}
