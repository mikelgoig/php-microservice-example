<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Doctrine;

use App\Catalog\Tag\Infrastructure\Doctrine\TagEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'books', schema: 'read')]
class BookEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public UuidV7 $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    public string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    public ?string $description;

    #[ORM\Column(type: 'boolean', options: [
        'default' => false,
    ])]
    public bool $deleted;

    #[ORM\Column(type: 'datetime_immutable', precision: 6)]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', precision: 6, nullable: true)]
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

    public function addTag(TagEntity $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    public function removeTag(TagEntity $tag): void
    {
        $this->tags->removeElement($tag);
    }
}
