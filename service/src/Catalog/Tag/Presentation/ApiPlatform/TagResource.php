<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use ApiPlatform\OpenApi\Model\Response as OpenApiResponse;
use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Domain\TagAlreadyExistsException;
use App\Catalog\Tag\Infrastructure\Doctrine\TagEntity;
use App\Catalog\Tag\Presentation\ApiPlatform\Create\CreateTagProcessor;
use App\Catalog\Tag\Presentation\ApiPlatform\Get\GetTagProvider;
use Symfony\Component\HttpFoundation\Response;
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
        new Post(
            openapi: new OpenApiOperation(
                responses: [
                    Response::HTTP_CONFLICT => new OpenApiResponse('Resource already exists'),
                ],
            ),
            exceptionToStatus: [
                TagAlreadyExistsException::class => Response::HTTP_CONFLICT,
            ],
            processor: CreateTagProcessor::class,
        ),
        // get tag
        new Get(
            exceptionToStatus: [
                CouldNotFindTagException::class => Response::HTTP_NOT_FOUND,
            ],
            provider: GetTagProvider::class,
            stateOptions: new Options(TagEntity::class),
        ),
        // delete tag
        new Delete(),
        // update tag
        new Patch(),
    ],
)]
final class TagResource
{
    /** The ID of the tag. */
    #[ApiProperty(writable: false, identifier: true)]
    public UuidV7 $id;

    /** The name of the tag. */
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ApiProperty(example: 'ddd')]
    public string $name;

    /** Indicates if the book has been deleted. */
    #[ApiProperty(readable: false, writable: false, default: false)]
    public bool $deleted;

    /** The creation date of the resource. */
    #[ApiProperty(writable: false)]
    public \DateTimeImmutable $createdAt;

    /** The update date of the resource. */
    #[ApiProperty(writable: false)]
    public ?\DateTimeImmutable $updatedAt;
}
