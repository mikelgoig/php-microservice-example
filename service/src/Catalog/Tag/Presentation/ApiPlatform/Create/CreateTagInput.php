<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform\Create;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTagInput
{
    /** The name of the tag. */
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ApiProperty(example: 'ddd')]
    public string $name;
}
