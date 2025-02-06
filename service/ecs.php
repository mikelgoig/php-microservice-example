<?php

declare(strict_types=1);

use MikelGoig\EasyCodingStandard\SetList as CodingStandard;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/bin',
        __DIR__ . '/config',
        __DIR__ . '/migrations',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])

    ->withRootFiles()

    ->withSets([CodingStandard::DEFAULT, CodingStandard::RISKY])

    ->withSkip([
        FinalClassFixer::class => [__DIR__ . '/src/Shared/Infrastructure/Symfony/Kernel.php'],
    ])
;
