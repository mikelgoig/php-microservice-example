<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform;

use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Presentation\ApiPlatform\Get\GetTagProvider;
use Symfony\Component\Uid\Uuid;

final readonly class TagFinder
{
    private const string GET_TAG_OPERATION = '_api_/tags/{id}{._format}_get';

    public function __construct(
        private ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
        private GetTagProvider $getTagProvider,
    ) {}

    /**
     * @param array<string, mixed> $context
     */
    public function find(Uuid $tagId, array $context): TagResource
    {
        $operation = $this->resourceMetadataCollectionFactory->create(TagResource::class)->getOperation(
            self::GET_TAG_OPERATION,
        );

        try {
            return $this->getTagProvider->provide($operation, [
                'id' => $tagId,
            ], $context);
        } catch (CouldNotFindTagException) {
            throw new \RuntimeException('Tag does not exist in the projection table.');
        }
    }
}
