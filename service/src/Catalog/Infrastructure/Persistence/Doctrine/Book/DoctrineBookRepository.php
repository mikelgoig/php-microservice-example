<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Book;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookReadModelRepository;
use App\Catalog\Domain\Model\Book\BookRepository;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends DoctrineRepository<Book>
 */
final class DoctrineBookRepository extends DoctrineRepository implements BookRepository, BookReadModelRepository
{
    private const ENTITY_CLASS = Book::class;
    private const ALIAS = 'book';

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Book $book): void
    {
        $this->entityManager->persist($book);
    }

    public function ofId(string $id): ?Book
    {
        return $this->entityManager->find(self::ENTITY_CLASS, $id);
    }

    public function exists(Criteria $criteria): bool
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select(self::ALIAS.'.id')
            ->from(self::ENTITY_CLASS, self::ALIAS)
            ->addCriteria($criteria)
            ->getQuery()
            ->getOneOrNullResult();

        return $result !== null;
    }
}
