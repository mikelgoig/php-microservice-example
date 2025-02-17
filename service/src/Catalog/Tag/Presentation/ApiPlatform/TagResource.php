<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource as ReadApiResource;
use ApiPlatform\Metadata\ApiResource as WriteApiResource;
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
use App\Catalog\Tag\Presentation\ApiPlatform\Create\CreateTagInput;
use App\Catalog\Tag\Presentation\ApiPlatform\Create\CreateTagProcessor;
use App\Catalog\Tag\Presentation\ApiPlatform\Delete\DeleteTagProcessor;
use App\Catalog\Tag\Presentation\ApiPlatform\Update\UpdateTagInput;
use App\Catalog\Tag\Presentation\ApiPlatform\Update\UpdateTagProcessor;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

/** A tag. */
#[ReadApiResource(
    shortName: 'Tag',
    operations: [
        // get tag
        new Get(),
        // list tags
        new GetCollection(
            order: [
                'name' => 'ASC',
            ],
        ),
    ],
    provider: EntityToDtoProvider::class,
    stateOptions: new Options(TagEntity::class),
)]
#[WriteApiResource(
    shortName: 'Tag',
    operations: [
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
            input: CreateTagInput::class,
            processor: CreateTagProcessor::class,
        ),
        // delete tag
        new Delete(
            status: Response::HTTP_OK,
            exceptionToStatus: [
                CouldNotFindTagException::class => Response::HTTP_NOT_FOUND,
            ],
            output: TagResource::class,
            read: false,
            processor: DeleteTagProcessor::class,
        ),
        // update tag
        new Patch(
            openapi: new OpenApiOperation(
                responses: [
                    Response::HTTP_CONFLICT => new OpenApiResponse('Resource already exists'),
                ],
            ),
            exceptionToStatus: [
                CouldNotFindTagException::class => Response::HTTP_NOT_FOUND,
                TagAlreadyExistsException::class => Response::HTTP_CONFLICT,
            ],
            input: UpdateTagInput::class,
            read: false,
            processor: UpdateTagProcessor::class,
        ),
    ],
)]
final class TagResource
{
    /** The ID of the tag. */
    #[ApiProperty(identifier: true)]
    public Uuid $id;

    /** The name of the tag. */
    #[ApiProperty(example: 'ddd')]
    public string $name;

    /** Indicates if the book has been deleted. */
    public bool $deleted;

    /** The creation date of the resource. */
    public \DateTimeImmutable $createdAt;

    /** The update date of the resource. */
    public ?\DateTimeImmutable $updatedAt;
}
