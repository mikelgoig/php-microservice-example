<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use Symfony\Component\Uid\Uuid;

trait BookProvider
{
    /**
     * @param array<string, mixed> $context
     * @throws CouldNotFindBookException
     */
    private function provide(Uuid $bookId, array $context): BookQueryResource
    {
        $metadataCollection = $this->resourceMetadataCollectionFactory->create(BookQueryResource::class);
        $getOperation = $metadataCollection->getOperation('_api_/books/{id}{._format}_get');
        return $this->getBookProvider->provide($getOperation, [
            'id' => $bookId,
        ], $context);
    }
}
