<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Book;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookReadModelRepository;
use App\Catalog\Domain\Model\Book\BookRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineBookRepository implements BookRepository, BookReadModelRepository
{
    /** @var class-string */
    private const string ENTITY_CLASS = Book::class;
    private const string ALIAS = 'book';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function save(Book $book): void
    {
        $this->entityManager->persist($book);
    }

    public function remove(Book $book): void
    {
        $this->entityManager->remove($book);
    }

    public function ofId(string $id): ?Book
    {
        return $this->entityManager->find(self::ENTITY_CLASS, $id);
    }

    public function exists(Criteria $criteria): bool
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select(self::ALIAS . '.id')
            ->from(self::ENTITY_CLASS, self::ALIAS)
            ->addCriteria($criteria)
            ->getQuery()
            ->getOneOrNullResult();

        return $result !== null;
    }
}
