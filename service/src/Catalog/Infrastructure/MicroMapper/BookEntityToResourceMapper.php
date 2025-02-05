<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\MicroMapper;

use App\Catalog\Infrastructure\Doctrine\Entity\Book;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookResource;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: Book::class, to: BookResource::class)]
final readonly class BookEntityToResourceMapper implements MapperInterface
{
    public function load(object $from, string $toClass, array $context): BookResource
    {
        return new BookResource();
    }

    public function populate(object $from, object $to, array $context): BookResource
    {
        $entity = $from;
        \assert($entity instanceof Book);
        $resource = $to;
        \assert($resource instanceof BookResource);

        $resource->id = $entity->id;
        $resource->name = $entity->name;
        $resource->deleted = $entity->deleted;
        $resource->createdAt = $entity->createdAt;
        $resource->updatedAt = $entity->updatedAt;
        return $resource;
    }
}
