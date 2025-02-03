<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone;

use App\Shared\Application\Bus\Command\Command;
use App\Shared\Application\Bus\Command\CommandBus;
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
