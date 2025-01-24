<?php

declare(strict_types=1);

namespace App\Tests\Support\Extension;

use Codeception\Events;
use Codeception\Extension;
use Codeception\Module\Symfony;
use Webmozart\Assert\Assert;

final class ApiPlatformEventSubscriber extends Extension
{
    protected array $config = [
        'openapi' => null,
    ];

    /** @var array<string, string> */
    protected static array $events = [
        Events::SUITE_BEFORE => 'beforeSuite',
    ];

    public function beforeSuite(): void
    {
        $this->exportOpenApiFile();
    }

    private function exportOpenApiFile(): void
    {
        Assert::string($this->config['openapi'], 'The <openapi> config must be set in the ApiPlatform extension.');

        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $symfony->runSymfonyConsoleCommand('api:openapi:export', [
            '--output' => $this->config['openapi'],
        ]);
    }
}
