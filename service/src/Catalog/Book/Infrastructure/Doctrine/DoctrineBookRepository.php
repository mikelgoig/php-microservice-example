<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Doctrine;

use App\Catalog\Book\Domain\BookReadModelRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookEntity>
 */
final class DoctrineBookRepository extends ServiceEntityRepository implements BookReadModelRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookEntity::class);
    }

    public function exists(Criteria $criteria): bool
    {
        $result = $this->createQueryBuilder('b')
            ->select('b.id')
            ->addCriteria($criteria)
            ->getQuery()
            ->getOneOrNullResult();

        return $result !== null;
    }
}
