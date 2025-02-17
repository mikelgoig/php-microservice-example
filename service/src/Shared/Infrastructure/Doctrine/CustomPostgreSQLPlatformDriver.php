<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class CustomPostgreSQLPlatformDriver extends AbstractDriverMiddleware
{
    public function createDatabasePlatformForVersion($version): AbstractPlatform
    {
        return new CustomPostgreSQLPlatform();
    }
}
