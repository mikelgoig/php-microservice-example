<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use ApiPlatform\OpenApi\Model\Response as OpenApiResponse;
use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookAlreadyExists;
use App\Catalog\Domain\Model\Book\CouldNotFindBook;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Book',
    operations: [
        // commands
        new Post(
            openapi: new OpenApiOperation(
                responses: [
                    Response::HTTP_CONFLICT => new OpenApiResponse('Book resource already exists'),
                ]
            ),
            exceptionToStatus: [BookAlreadyExists::class => Response::HTTP_CONFLICT],
            processor: CreateBookProcessor::class,
        ),
        // queries
        new Get(
            exceptionToStatus: [CouldNotFindBook::class => Response::HTTP_NOT_FOUND],
            provider: GetBookProvider::class,
        ),
        new GetCollection(
            provider: ListBooksProvider::class
        ),
    ],
)]
final class BookResource
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false, identifier: true)]
        public ?UuidV7 $id = null,

        #[Assert\NotNull]
        #[Assert\Length(min: 1, max: 255)]
        public ?string $name = null,
    ) {
    }

    public static function fromModel(Book $book): self
    {
        return new self(
            UuidV7::fromString($book->id()),
            $book->name(),
        );
    }
}
