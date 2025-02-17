<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Infrastructure\Doctrine;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'tags', schema: 'read')]
class TagEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    public Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    public string $name;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'default' => false,
    ])]
    public bool $deleted;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, precision: 6)]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    public ?\DateTimeImmutable $updatedAt;

    /**
     * Used in tests by the entity factory.
     */
    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }
}
