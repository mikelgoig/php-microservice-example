<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Create;

use ApiPlatform\Metadata\ApiProperty;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateBookInput
{
    /** The name of the book. */
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ApiProperty(example: 'Advanced Web Application Architecture')]
    public string $name;

    /** The description of the book. */
    #[Assert\NotBlank(allowNull: true)]
    #[ApiProperty(example: 'A practical guide to build web applications in a sustainable manner.')]
    public ?string $description = null;

    /**
     * The tags associated to the book.
     * @var iterable<TagResource> $tags
     */
    #[ApiProperty(example: ['/api/tags/0194e718-170e-7552-92df-953e34e6a7ac'])]
    public iterable $tags = [];
}
