<?php

declare(strict_types=1);

namespace App\Catalog\Tag;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\UuidV7;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;

#[AsMapper(from: TagResource::class, to: TagEntity::class)]
final readonly class TagResourceToEntityMapper implements MapperInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function load(object $from, string $toClass, array $context): TagEntity
    {
        $resource = $from;
        \assert($resource instanceof TagResource);

        if ($resource->id !== null) {
            return $this->entityManager->find(TagEntity::class, $resource->id)
                ?? throw new \RuntimeException("Tag <{$resource->id}> not found.");
        }

        return new TagEntity(new UuidV7(), $resource->name);
    }

    public function populate(object $from, object $to, array $context): TagEntity
    {
        $resource = $from;
        \assert($resource instanceof TagResource);
        $entity = $to;
        \assert($entity instanceof TagEntity);

        $entity->setName($resource->name);
        return $entity;
    }
}
