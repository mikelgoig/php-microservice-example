<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Presentation\ApiPlatform\Book\Provider\GetBookProvider;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookResource;
use Symfony\Component\Uid\Uuid;

final readonly class BookFinder
{
    private const string GET_BOOK_OPERATION = '_api_/books/{id}{._format}_get';

    public function __construct(
        private ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
        private GetBookProvider $getBookProvider,
    ) {}

    /**
     * @param array<string, mixed> $context
     */
    public function find(Uuid $bookId, array $context): BookResource
    {
        $operation = $this->resourceMetadataCollectionFactory->create(BookResource::class)->getOperation(
            self::GET_BOOK_OPERATION,
        );

        try {
            return $this->getBookProvider->provide($operation, [
                'id' => $bookId,
            ], $context);
        } catch (CouldNotFindBookException) {
            throw new \RuntimeException('Book does not exist in the projection table.');
        }
    }
}
