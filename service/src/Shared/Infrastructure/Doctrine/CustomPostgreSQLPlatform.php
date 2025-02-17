<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;

/**
 * Custom implementation of the PostgreSQL platform, disabling foreign key constraints.
 * This decision is directly related to the use of Doctrine in a **read-only schema** context.
 */
final class CustomPostgreSQLPlatform extends PostgreSQLPlatform
{
    public function supportsForeignKeyConstraints(): bool
    {
        return false;
    }
}
