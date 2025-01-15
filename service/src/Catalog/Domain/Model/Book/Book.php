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
    private int $idPrimary;

    private function __construct(
        #[ORM\Column(type: 'uuid', unique: true)]
        private string $id,
        #[ORM\Column(length: 255)]
        private string $name,
    ) {
    }

    public static function create(string $id, string $name): self
    {
        return new self($id, $name);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
