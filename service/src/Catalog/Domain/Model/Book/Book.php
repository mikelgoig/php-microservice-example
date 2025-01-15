<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
final readonly class Book
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $idPrimary;

    private function __construct(
        #[ORM\Column(type: 'uuid', unique: true)]
        protected string $id,
        #[ORM\Column(length: 255)]
        protected string $name,
    ) {
    }

    public static function create(string $id, string $name): self
    {
        return new self($id, $name);
    }
}
