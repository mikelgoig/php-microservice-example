<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use App\Catalog\Book\Infrastructure\Doctrine\BookEntity;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\Uid\Uuid;

final readonly class BookFinder
{
    /**
     * @param EntityToDtoProvider<BookEntity, BookResource> $entityToDtoProvider
     */
    public function __construct(
        private ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
        private EntityToDtoProvider $entityToDtoProvider,
    ) {}

    /**
     * @param array<string, mixed> $context
     */
    public function find(Uuid $bookId, array $context): BookResource
    {
        $operation = $this->resourceMetadataCollectionFactory->create(BookResource::class)->getOperation();
        \assert($operation instanceof Get);

        return $this->entityToDtoProvider->provide($operation, [
            'id' => $bookId,
        ], $context) ?? throw new \RuntimeException('Book does not exist in the projection table.');
    }
}
