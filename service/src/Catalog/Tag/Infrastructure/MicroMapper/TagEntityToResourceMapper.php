<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Infrastructure\MicroMapper;

use App\Catalog\Tag\Infrastructure\Doctrine\TagEntity;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: TagEntity::class, to: TagResource::class)]
final readonly class TagEntityToResourceMapper implements MapperInterface
{
    public function load(object $from, string $toClass, array $context): TagResource
    {
        return new TagResource();
    }

    public function populate(object $from, object $to, array $context): TagResource
    {
        $entity = $from;
        \assert($entity instanceof TagEntity);
        $resource = $to;
        \assert($resource instanceof TagResource);

        $resource->id = $entity->id;
        $resource->name = $entity->name;
        $resource->deleted = $entity->deleted;
        $resource->createdAt = $entity->createdAt;
        $resource->updatedAt = $entity->updatedAt;
        return $resource;
    }
}
