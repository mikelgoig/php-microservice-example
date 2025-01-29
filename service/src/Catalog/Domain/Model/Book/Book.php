<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
readonly class Book
{
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', unique: true)]
        protected string $id,
        #[ORM\Column(length: 255)]
        protected string $name,
    ) {}

    public static function create(string $id, string $name): self
    {
        return new self($id, $name);
    }
}
