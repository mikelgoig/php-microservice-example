<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

use Doctrine\Common\Collections\Criteria;

final readonly class TagChecker
{
    public function __construct(
        private TagReadModelRepository $tagReadModels,
    ) {}

    /**
     * @throws TagAlreadyExistsException
     */
    public function ensureThatThereIsNoTagWithName(string $name, ?TagId $excludingId = null): void
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('name', $name));

        if ($excludingId !== null) {
            $criteria = $criteria->andWhere(Criteria::expr()->neq('id', $excludingId->value));
        }

        if ($this->tagReadModels->exists($criteria)) {
            throw TagAlreadyExistsException::withName($name);
        }
    }
}
