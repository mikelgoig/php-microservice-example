<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Doctrine;

use App\Catalog\Tag\TagEntity;
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
    private UuidV7 $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $name;

    #[ORM\Column(type: 'boolean', options: [
        'default' => false,
    ])]
    private bool $deleted;

    #[ORM\Column(type: 'datetime_immutable', precision: 6)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', precision: 6, nullable: true)]
    private ?\DateTimeImmutable $updatedAt;

    /** @var Collection<int, TagEntity> */
    #[ORM\JoinTable(name: 'books_tags', schema: 'read')]
    #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: TagEntity::class)]
    private Collection $tags;

    public function __construct(UuidV7 $id, string $name, bool $deleted)
    {
        $this->id = $id;
        $this->name = $name;
        $this->deleted = $deleted;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = null;
        $this->tags = new ArrayCollection();
    }

    public function id(): UuidV7
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, TagEntity>
     */
    public function tags(): Collection
    {
        return $this->tags;
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
