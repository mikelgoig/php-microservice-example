<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone\Config;

use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\SymfonyBundle\Config\SymfonyConnectionReference;

final readonly class EcotoneConfiguration
{
    #[ServiceContext]
    public function dbalConfiguration(): SymfonyConnectionReference
    {
        $connection = SymfonyConnectionReference::defaultConnection('default');
        \assert($connection instanceof SymfonyConnectionReference);
        return $connection;
    }
}
