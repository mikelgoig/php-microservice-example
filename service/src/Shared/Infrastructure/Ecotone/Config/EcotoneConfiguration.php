<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone\Config;

use Ecotone\JMSConverter\JMSConverterConfiguration;
use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\SymfonyBundle\Config\SymfonyConnectionReference;

final readonly class EcotoneConfiguration
{
    #[ServiceContext]
    public function dbalConfiguration(): SymfonyConnectionReference
    {
        $connection = SymfonyConnectionReference::defaultConnection('ecotone');
        \assert($connection instanceof SymfonyConnectionReference);
        return $connection;
    }

    #[ServiceContext]
    public function jmsConfiguration(): JMSConverterConfiguration
    {
        $config = JMSConverterConfiguration::createWithDefaults();
        \assert($config instanceof JMSConverterConfiguration);
        return $config->withDefaultNullSerialization(true);
    }
}
