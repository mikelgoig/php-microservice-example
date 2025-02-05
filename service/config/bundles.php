<?php

declare(strict_types=1);

return [
    ApiPlatform\Symfony\Bundle\ApiPlatformBundle::class => [
        'all' => true,
    ],
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class => [
        'test' => true,
    ],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => [
        'all' => true,
    ],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => [
        'all' => true,
    ],
    Ecotone\SymfonyBundle\EcotoneSymfonyBundle::class => [
        'all' => true,
    ],
    Nelmio\CorsBundle\NelmioCorsBundle::class => [
        'all' => true,
    ],
    Symfony\Bundle\DebugBundle\DebugBundle::class => [
        'dev' => true,
    ],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => [
        'all' => true,
    ],
    Symfony\Bundle\MakerBundle\MakerBundle::class => [
        'dev' => true,
    ],
    Symfony\Bundle\MonologBundle\MonologBundle::class => [
        'all' => true,
    ],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => [
        'all' => true,
    ],
    Symfony\Bundle\TwigBundle\TwigBundle::class => [
        'all' => true,
    ],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => [
        'dev' => true,
        'test' => true,
    ],
    Symfonycasts\MicroMapper\SymfonycastsMicroMapperBundle::class => [
        'all' => true,
    ],
    Zenstruck\Foundry\ZenstruckFoundryBundle::class => [
        'dev' => true,
        'test' => true,
    ],
];
