<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Doctrine;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'books', schema: 'projections')]
class Book
{
    #[ORM\Column(type: 'uuid', unique: true)]
    public UuidV7 $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    public string $name;

    #[ORM\Column(type: 'boolean', options: [
        'default' => false,
    ])]
    public bool $deleted;

    #[ORM\Column(type: 'datetime_immutable', precision: 6)]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', precision: 6, nullable: true)]
    public ?\DateTimeImmutable $updatedAt;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $idPrimary;
}
