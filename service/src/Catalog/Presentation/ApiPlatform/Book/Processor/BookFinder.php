<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Presentation\ApiPlatform\Book\Provider\GetBookProvider;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

final readonly class BookFinder
{
    private const string GET_BOOK_OPERATION = '_api_/books/{id}{._format}_get';

    public function __construct(
        private ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
        #[Autowire(service: GetBookProvider::class)]
        private ProviderInterface $getBookProvider,
    ) {}

    /**
     * @param array<mixed> $context
     */
    public function find(Uuid $bookId, array $context): BookResource
    {
        $operation = $this->resourceMetadataCollectionFactory->create(BookResource::class)->getOperation(
            self::GET_BOOK_OPERATION,
        );
        return $this->getBookProvider->provide($operation, [
            'id' => $bookId,
        ], $context);
    }
}
