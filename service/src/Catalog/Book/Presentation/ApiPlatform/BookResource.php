<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform;

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
use App\Catalog\Book\Domain\BookAlreadyExistsException;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use App\Catalog\Book\Infrastructure\Doctrine\BookEntity;
use App\Catalog\Book\Presentation\ApiPlatform\Create\CreateBookInput;
use App\Catalog\Book\Presentation\ApiPlatform\Create\CreateBookProcessor;
use App\Catalog\Book\Presentation\ApiPlatform\Delete\DeleteBookProcessor;
use App\Catalog\Book\Presentation\ApiPlatform\Update\UpdateBookInput;
use App\Catalog\Book\Presentation\ApiPlatform\Update\UpdateBookProcessor;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

/** A book. */
#[ReadApiResource(
    shortName: 'Book',
    operations: [
        // get book
        new Get(),
        // list books
        new GetCollection(
            order: [
                'id' => 'DESC',
            ],
        ),
    ],
    provider: EntityToDtoProvider::class,
    stateOptions: new Options(BookEntity::class),
)]
#[WriteApiResource(
    shortName: 'Book',
    operations: [
        // create book
        new Post(
            openapi: new OpenApiOperation(
                responses: [
                    Response::HTTP_CONFLICT => new OpenApiResponse('Resource already exists'),
                ],
            ),
            exceptionToStatus: [
                BookAlreadyExistsException::class => Response::HTTP_CONFLICT,
            ],
            input: CreateBookInput::class,
            processor: CreateBookProcessor::class,
        ),
        // delete book
        new Delete(
            status: Response::HTTP_OK,
            exceptionToStatus: [
                CouldNotFindBookException::class => Response::HTTP_NOT_FOUND,
            ],
            output: BookResource::class,
            read: false,
            processor: DeleteBookProcessor::class,
        ),
        // update book
        new Patch(
            openapi: new OpenApiOperation(
                responses: [
                    Response::HTTP_CONFLICT => new OpenApiResponse('Resource already exists'),
                ],
            ),
            exceptionToStatus: [
                CouldNotFindBookException::class => Response::HTTP_NOT_FOUND,
                BookAlreadyExistsException::class => Response::HTTP_CONFLICT,
            ],
            input: UpdateBookInput::class,
            read: false,
            processor: UpdateBookProcessor::class,
        ),
    ],
)]
final class BookResource
{
    /** The ID of the book. */
    #[ApiProperty(identifier: true)]
    public Uuid $id;

    /** The name of the book. */
    #[ApiProperty(example: 'Advanced Web Application Architecture')]
    public string $name;

    /** The description of the book. */
    #[ApiProperty(example: 'A practical guide to build web applications in a sustainable manner.')]
    public ?string $description;

    /**
     * The tags associated to the book.
     * @var iterable<TagResource> $tags
     */
    #[ApiProperty(example: ['/api/tags/0194e718-170e-7552-92df-953e34e6a7ac'])]
    public iterable $tags;

    /** Indicates if the book has been deleted. */
    public bool $deleted;

    /** The creation date of the resource. */
    public \DateTimeInterface $createdAt;

    /** The update date of the resource. */
    public ?\DateTimeInterface $updatedAt;
}
