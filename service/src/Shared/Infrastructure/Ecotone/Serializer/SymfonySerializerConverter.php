<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ecotone\Serializer;

use Ecotone\Messaging\Attribute\MediaTypeConverter;
use Ecotone\Messaging\Conversion\ConversionException;
use Ecotone\Messaging\Conversion\Converter;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Handler\TypeDescriptor;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Based on the Ecotone JMS Converter.
 * @link https://github.com/ecotoneframework/jms-converter/blob/main/src/JMSConverter.php
 */
#[MediaTypeConverter]
final readonly class SymfonySerializerConverter implements Converter
{
    public function __construct(
        private DenormalizerInterface&NormalizerInterface $serializer,
    ) {}

    public function matches(
        TypeDescriptor $sourceType,
        MediaType $sourceMediaType,
        TypeDescriptor $targetType,
        MediaType $targetMediaType,
    ): bool {
        if ($sourceMediaType->isCompatibleWith(MediaType::createApplicationXPHP())
            && $targetMediaType->isCompatibleWith(MediaType::createApplicationXPHP())) {
            return $sourceType->isIterable() && ($targetType->isClassOrInterface() || $targetType->isIterable())
                || ($sourceType->isClassOrInterface() || $sourceType->isIterable()) && $targetType->isIterable();
        }

        return false;
    }

    /**
     * @param mixed $source
     */
    public function convert(
        $source,
        TypeDescriptor $sourceType,
        MediaType $sourceMediaType,
        TypeDescriptor $targetType,
        MediaType $targetMediaType,
    ): mixed {
        try {
            if ($sourceMediaType->isCompatibleWith(
                MediaType::createApplicationXPHP(),
            ) && $targetMediaType->isCompatibleWith(MediaType::createApplicationXPHP())) {
                if ($sourceType->isIterable() && !$targetType->isArrayButNotClassBasedCollection()) {
                    return $this->serializer->denormalize($source, $targetType->toString());
                } elseif ($targetType->isIterable()) {
                    return $this->serializer->normalize($source, $targetType->toString());
                }
            }

            throw new \LogicException('Invalid conversion.');
        } catch (\Throwable $exception) {
            throw ConversionException::createFromPreviousException(
                "Can't convert from {$sourceMediaType}:{$sourceType} to {$targetMediaType}:{$targetType} :" . $exception->getMessage(),
                $exception,
            );
        }
    }
}
