<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone\Symfony;

use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\SymfonyBundle\Config\SymfonyConnectionReference;

final readonly class SymfonyDoctrineConfiguration
{
    #[ServiceContext]
    public function configuration(): SymfonyConnectionReference
    {
        $connection = SymfonyConnectionReference::defaultConnection('ecotone');
        \assert($connection instanceof SymfonyConnectionReference);
        return $connection;
    }
}
