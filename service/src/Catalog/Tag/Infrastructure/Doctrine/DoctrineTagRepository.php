<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Infrastructure\Doctrine;

use App\Catalog\Tag\Domain\TagReadModelRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TagEntity>
 */
final class DoctrineTagRepository extends ServiceEntityRepository implements TagReadModelRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagEntity::class);
    }

    public function exists(Criteria $criteria): bool
    {
        $result = $this->createQueryBuilder('t')
            ->select('t.id')
            ->addCriteria($criteria)
            ->getQuery()
            ->getOneOrNullResult();

        return $result !== null;
    }
}
