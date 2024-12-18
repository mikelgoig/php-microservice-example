<?php

declare(strict_types=1);

namespace App\Tests\Support\Extension;

use Codeception\Events;
use Codeception\Extension;

final class Database extends Extension
{
    /**
     * @var array<string, string>
     */
    public static array $events = [
        Events::TEST_BEFORE => 'beforeTest',
    ];

    /** @noinspection PhpUnused */
    public function beforeTest(): void
    {
        exec('bin/console doctrine:database:drop --env=test --force');
        exec('bin/console doctrine:database:create --env=test');
        exec('bin/console doctrine:migrations:migrate --env=test --no-interaction');
    }
}
