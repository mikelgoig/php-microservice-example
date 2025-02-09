<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\MicroMapper;

use App\Catalog\Book\Infrastructure\Doctrine\BookEntity;
use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: BookEntity::class, to: BookResource::class)]
final readonly class BookEntityToResourceMapper implements MapperInterface
{
    public function load(object $from, string $toClass, array $context): BookResource
    {
        return new BookResource();
    }

    public function populate(object $from, object $to, array $context): BookResource
    {
        $entity = $from;
        \assert($entity instanceof BookEntity);
        $resource = $to;
        \assert($resource instanceof BookResource);

        $resource->id = $entity->id();
        $resource->name = $entity->name();
        $resource->description = $entity->description();
        $resource->tags = $entity->tags();
        $resource->deleted = $entity->isDeleted();
        $resource->createdAt = $entity->createdAt();
        $resource->updatedAt = $entity->updatedAt();
        return $resource;
    }
}
