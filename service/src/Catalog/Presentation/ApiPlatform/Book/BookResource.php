<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Catalog\Domain\Model\Book\Book;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Book',
    operations: [
        // commands
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateBookProcessor::class,
        ),
        // queries
        new Get(
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

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
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
