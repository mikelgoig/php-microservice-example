<?php

declare(strict_types=1);

namespace App\Catalog\Tag;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TagEntity>
 */
final class DoctrineEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagEntity::class);
    }

    /**
     * Finds a tag entity by name (and optionally excludes a specific ID).
     *
     * Used by the UniqueEntity validation constraint.
     *
     * @param array<string, mixed> $fields
     */
    public function uniqueName(array $fields): mixed
    {
        \assert(isset($fields['name']), sprintf('"%s" requires the "name" field.', __METHOD__));

        $qb = $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->setParameter('name', $fields['name']);

        if ($fields['id'] !== null) {
            $qb->andWhere('t.id != :id')
                ->setParameter('id', $fields['id']);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
