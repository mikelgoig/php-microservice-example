<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use ApiPlatform\OpenApi\Model\Response as OpenApiResponse;
use App\Catalog\Domain\Model\Book\BookAlreadyExistsException;
use App\Catalog\Presentation\ApiPlatform\Book\Processor\CreateBookProcessor;
use Symfony\Component\HttpFoundation\Response;
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
    ],
)]
final class BookCommandResource
{
    /** The name of the book. */
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 255)]
    public string $name;
}
