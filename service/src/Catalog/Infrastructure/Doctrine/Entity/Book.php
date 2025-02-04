<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'books')]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public UuidV7 $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    public string $name;

    #[ORM\Column(type: 'boolean', options: [
        'default' => false,
    ])]
    public bool $deleted;
}
