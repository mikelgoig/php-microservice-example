<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Symfony\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->bootEnv(__DIR__ . '/../.env');

$environment = $_SERVER['APP_ENV'];
\assert(is_string($environment));
$kernel = new Kernel($environment, (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
return $kernel->getContainer()->get('doctrine')->getManager();
