<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsMiddleware;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Middleware;

#[AsMiddleware(connections: ['default'])]
final readonly class CustomPostgreSQLPlatformMiddleware implements Middleware
{
    public function wrap(Driver $driver): Driver
    {
        return new CustomPostgreSQLPlatformDriver($driver);
    }
}
