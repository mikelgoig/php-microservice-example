<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Book;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineBookRepository implements BookRepository
{
    private const ENTITY_CLASS = Book::class;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Book $book): void
    {
        $this->entityManager->persist($book);
    }

    public function ofId(string $id): ?Book
    {
        return $this->entityManager->find(self::ENTITY_CLASS, $id);
    }
}
