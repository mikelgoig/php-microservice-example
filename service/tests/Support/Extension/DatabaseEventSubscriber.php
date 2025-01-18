<?php

declare(strict_types=1);

namespace App\Tests\Support\Extension;

use Codeception\Events;
use Codeception\Extension;
use Codeception\Module\Symfony;

final class DatabaseEventSubscriber extends Extension
{
    /** @var array<string, string> */
    public static array $events = [
        Events::TEST_BEFORE => 'beforeTest',
    ];

    /**
     * @noinspection PhpUnused
     */
    public function beforeTest(): void
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $entityManager = $symfony->_getEntityManager();
        $entityManager->flush();
        $entityManager->clear();
        $entityManager->getConnection()->close();
        $symfony->runSymfonyConsoleCommand('doctrine:database:drop', [
            '--if-exists' => true,
            '--force' => true,
        ]);
        $symfony->runSymfonyConsoleCommand('doctrine:database:create');
        $symfony->runSymfonyConsoleCommand('doctrine:migrations:migrate', [
            '--no-interaction' => true,
        ]);
    }
}
