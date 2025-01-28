<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Symfony\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

if ((bool) $_SERVER['APP_DEBUG']) {
    umask(0000);
}

//> dama/doctrine-test-bundle
function freshDatabase(): void
{
    $kernel = new Kernel('test', true);
    $kernel->boot();

    $application = new Application($kernel);
    $application->setCatchExceptions(false);
    $application->setAutoExit(false);

    $application->run(new ArrayInput([
        'command' => 'doctrine:database:drop',
        '--if-exists' => '1',
        '--force' => '1',
        '--no-interaction' => '1',
    ]));

    $application->run(new ArrayInput([
        'command' => 'doctrine:database:create',
        '--no-interaction' => '1',
    ]));

    $application->run(new ArrayInput([
        'command' => 'doctrine:migrations:migrate',
        '--allow-no-migration' => '1',
        '--all-or-nothing' => '1',
        '--no-interaction' => '1',
    ]));

    $kernel->shutdown();
}

freshDatabase();
//< dama/doctrine-test-bundle
