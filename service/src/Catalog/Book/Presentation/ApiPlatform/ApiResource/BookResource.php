<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\ApiResource;

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
use App\Catalog\Book\Domain\BookAlreadyExistsException;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use App\Catalog\Book\Infrastructure\Doctrine\Book;
use App\Catalog\Book\Presentation\ApiPlatform\Processor\CreateBookProcessor;
use App\Catalog\Book\Presentation\ApiPlatform\Processor\DeleteBookProcessor;
use App\Catalog\Book\Presentation\ApiPlatform\Processor\UpdateBookProcessor;
use App\Catalog\Book\Presentation\ApiPlatform\Provider\GetBookProvider;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

/** A book. */
#[ApiResource(
    shortName: 'Book',
    operations: [
        // list books
        new GetCollection(
            order: [
                'id' => 'DESC',
            ],
            provider: EntityToDtoProvider::class,
            stateOptions: new Options(Book::class),
        ),
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
            processor: CreateBookProcessor::class,
        ),
        // get book
        new Get(
            exceptionToStatus: [
                CouldNotFindBookException::class => Response::HTTP_NOT_FOUND,
            ],
            provider: GetBookProvider::class,
            stateOptions: new Options(Book::class),
        ),
        // delete book
        new Delete(
            exceptionToStatus: [
                CouldNotFindBookException::class => Response::HTTP_NOT_FOUND,
            ],
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
            read: false,
            processor: UpdateBookProcessor::class,
        ),
    ],
)]
final class BookResource
{
    /** The ID of the book. */
    #[ApiProperty(writable: false, identifier: true)]
    public UuidV7 $id;

    /** The name of the book. */
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 255)]
    #[ApiProperty(example: 'Advanced Web Application Architecture')]
    public string $name;

    /** Indicates if the book has been deleted. */
    #[ApiProperty(readable: false, writable: false)]
    public bool $deleted;

    /** The creation date of the resource. */
    #[ApiProperty(writable: false)]
    public \DateTimeInterface $createdAt;

    /** The update date of the resource. */
    #[ApiProperty(writable: false)]
    public ?\DateTimeInterface $updatedAt;
}
