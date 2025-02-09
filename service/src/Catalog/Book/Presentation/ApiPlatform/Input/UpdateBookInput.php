<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateBookInput
{
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[ApiProperty(example: 'Advanced Web Application Architecture')]
    public string $name;

    #[Assert\NotBlank(allowNull: true)]
    #[ApiProperty(example: 'A practical guide to build web applications in a sustainable manner.')]
    public ?string $description;
}
