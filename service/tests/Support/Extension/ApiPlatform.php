<?php

declare(strict_types=1);

namespace App\Tests\Support\Extension;

use Codeception\Events;
use Codeception\Extension;
use Codeception\Module\Symfony;

final class ApiPlatform extends Extension
{
    private const OPENAPI_FILE_PATH = 'var/data/openapi.json';

    /**
     * @var array<string, string>
     */
    public static array $events = [
        Events::SUITE_BEFORE => 'beforeSuite',
    ];

    /** @noinspection PhpUnused */
    public function beforeSuite(): void
    {
        $this->exportOpenApiFile();
    }

    private function exportOpenApiFile(): void
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->runSymfonyConsoleCommand('api:openapi:export', ['--output' => self::OPENAPI_FILE_PATH]);
    }
}
