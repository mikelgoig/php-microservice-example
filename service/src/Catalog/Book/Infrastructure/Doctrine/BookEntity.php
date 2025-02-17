<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Doctrine;

use App\Catalog\Tag\Infrastructure\Doctrine\TagEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'books', schema: 'read')]
class BookEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    public Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    public string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $description;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'default' => false,
    ])]
    public bool $deleted;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, precision: 6)]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    public ?\DateTimeImmutable $updatedAt;

    /** @var Collection<int, TagEntity> */
    #[ORM\JoinTable(name: 'books_tags', schema: 'read')]
    #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: TagEntity::class)]
    public Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Used in tests by the entity factory.
     */
    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    /**
     * Used in tests by the entity factory.
     */
    public function addTag(TagEntity $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    /**
     * Used in tests by the entity factory.
     */
    public function removeTag(TagEntity $tag): void
    {
        $this->tags->removeElement($tag);
    }
}
