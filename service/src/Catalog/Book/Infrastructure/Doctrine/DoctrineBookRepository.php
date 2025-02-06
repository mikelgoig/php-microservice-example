<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Doctrine;

use App\Catalog\Book\Domain\BookReadModelRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineBookRepository implements BookReadModelRepository
{
    private const string ENTITY_CLASS = Book::class;
    private const string ALIAS = 'books';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

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
