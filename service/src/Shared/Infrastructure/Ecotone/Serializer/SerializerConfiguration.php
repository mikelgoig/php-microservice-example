<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone\Serializer;

use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\Messaging\Config\ServiceConfiguration;
use Ecotone\Messaging\Conversion\MediaType;

final readonly class SerializerConfiguration
{
    #[ServiceContext]
    public function configuration(): ServiceConfiguration
    {
        return ServiceConfiguration::createWithDefaults()
            ->withDefaultSerializationMediaType(MediaType::APPLICATION_JSON);
    }
}
