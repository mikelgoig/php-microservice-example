<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use ApiPlatform\OpenApi\Model\Response as OpenApiResponse;
use App\Catalog\Domain\Model\Book\BookAlreadyExistsException;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Presentation\ApiPlatform\Book\Processor\CreateBookProcessor;
use App\Catalog\Presentation\ApiPlatform\Book\Processor\DeleteBookProcessor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

/** A book. */
#[ApiResource(
    shortName: 'Book',
    operations: [
        // create book
        new Post(
            openapi: new OpenApiOperation(
                responses: [
                    Response::HTTP_CONFLICT => new OpenApiResponse('Book resource already exists'),
                ],
            ),
            exceptionToStatus: [
                BookAlreadyExistsException::class => Response::HTTP_CONFLICT,
            ],
            output: BookQueryResource::class,
            processor: CreateBookProcessor::class,
        ),
        // delete book
        new Delete(read: false, processor: DeleteBookProcessor::class),
    ],
    exceptionToStatus: [
        CouldNotFindBookException::class => Response::HTTP_NOT_FOUND,
    ],
)]
final class BookCommandResource
{
    /** The ID of the book. */
    #[ApiProperty(writable: false, identifier: true)]
    public UuidV7 $id;

    /** The name of the book. */
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 255)]
    public string $name;
}
