<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Book',
    operations: [
        // commands
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateBookProcessor::class,
        ),
    ],
)]
final class BookResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Assert\Uuid(versions: Assert\Uuid::V7_MONOTONIC, groups: ['create', 'Default'])]
        public ?string $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $name = null,
    ) {
    }

    public static function fromId(string $id): self
    {
        return new self($id);
    }
}
