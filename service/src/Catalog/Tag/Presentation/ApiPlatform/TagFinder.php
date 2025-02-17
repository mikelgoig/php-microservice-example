<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use App\Catalog\Tag\Infrastructure\Doctrine\TagEntity;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\Uid\Uuid;

final readonly class TagFinder
{
    /**
     * @param EntityToDtoProvider<TagEntity, TagResource> $entityToDtoProvider
     */
    public function __construct(
        private ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
        private EntityToDtoProvider $entityToDtoProvider,
    ) {}

    /**
     * @param array<string, mixed> $context
     */
    public function find(Uuid $tagId, array $context): TagResource
    {
        $operation = $this->resourceMetadataCollectionFactory->create(TagResource::class)->getOperation();
        \assert($operation instanceof Get);

        return $this->entityToDtoProvider->provide($operation, [
            'id' => $tagId,
        ], $context) ?? throw new \RuntimeException('Tag does not exist in the projection table.');
    }
}
