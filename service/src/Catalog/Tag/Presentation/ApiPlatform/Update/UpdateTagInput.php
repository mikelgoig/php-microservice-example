<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform\Update;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateTagInput
{
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[ApiProperty(example: 'clean-architecture')]
    public string $name;
}
