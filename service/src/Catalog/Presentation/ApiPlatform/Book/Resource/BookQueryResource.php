<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Presentation\ApiPlatform\Book\Provider\GetBookProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;

/** A book. */
#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'books')]
#[ApiResource(
    shortName: 'Book',
    operations: [
        // list books
        new GetCollection(
            order: [
                'id' => 'DESC',
            ],
        ),
        // get book
        new Get(
            exceptionToStatus: [
                CouldNotFindBookException::class => Response::HTTP_NOT_FOUND,
            ],
            provider: GetBookProvider::class,
        ),
    ],
)]
class BookQueryResource
{
    /** The ID of the book. */
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(writable: false, identifier: true)]
    public UuidV7 $id;

    /** The name of the book. */
    #[ORM\Column]
    public string $name;
}
