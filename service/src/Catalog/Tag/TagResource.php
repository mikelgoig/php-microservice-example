<?php

declare(strict_types=1);

namespace App\Catalog\Tag;

use ApiPlatform\Doctrine\Orm\State\Options as DoctrineOptions;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Shared\Infrastructure\ApiPlatform\Processor\EntityToDtoProcessor;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

/** A tag. */
#[ApiResource(
    shortName: 'Tag',
    operations: [
        // list tags
        new GetCollection(
            order: [
                'name' => 'ASC',
            ],
        ),
        // create tag
        new Post(),
        // get tag
        new Get(),
        // delete tag
        new Delete(),
        // update tag
        new Patch(),
    ],
    provider: EntityToDtoProvider::class,
    processor: EntityToDtoProcessor::class,
    stateOptions: new DoctrineOptions(entityClass: TagEntity::class),
)]
#[UniqueEntity(fields: 'name', message: 'Tag with name <{{ value }}> already exists.', entityClass: TagEntity::class)]
final class TagResource
{
    /** The ID of the tag. */
    #[ApiProperty(writable: false, identifier: true)]
    public ?UuidV7 $id = null;

    /** The name of the tag. */
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    #[ApiProperty(example: 'ddd')]
    public string $name = '';

    /** The creation date of the resource. */
    #[ApiProperty(writable: false)]
    public \DateTimeImmutable $createdAt;

    /** The update date of the resource. */
    #[ApiProperty(writable: false)]
    public ?\DateTimeImmutable $updatedAt;
}
