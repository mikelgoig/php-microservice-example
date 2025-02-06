<?php

declare(strict_types=1);

namespace App\Catalog\Tag;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Shared\Domain\DateTime\DateTimeCreator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

/** A tag. */
#[ORM\Entity]
#[ORM\Table(name: 'tags')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('name', message: 'Tag with name <{{ value }}> already exists.')]
#[ApiResource(
    operations: [
        // create tag
        new Post(),
        // get tag
        new Get(),
    ],
)]
class Tag
{
    /** The ID of the tag. */
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(writable: false, identifier: true)]
    public ?UuidV7 $id = null;

    /** The name of the tag. */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    #[ApiProperty(example: 'ddd')]
    public string $name;

    /** The creation date of the resource. */
    #[ORM\Column(type: 'datetime_immutable', precision: 6)]
    #[ApiProperty(writable: false)]
    public \DateTimeImmutable $createdAt;

    /** The update date of the resource. */
    #[ORM\Column(type: 'datetime_immutable', precision: 6, nullable: true)]
    #[ApiProperty(writable: false)]
    public ?\DateTimeImmutable $updatedAt;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->id = $this->id !== null ? $this->id : new UuidV7();
        $this->createdAt = DateTimeCreator::now();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = DateTimeCreator::now();
    }
}
