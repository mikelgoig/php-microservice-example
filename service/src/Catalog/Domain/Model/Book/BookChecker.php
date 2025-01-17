<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use Doctrine\Common\Collections\Criteria;

final readonly class BookChecker
{
    public function __construct(
        private BookReadModelRepository $bookReadModels,
    ) {}

    /**
     * @throws BookAlreadyExists
     */
    public function ensureThatThereIsNoBookWithName(string $name, ?string $excludingId = null): void
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('name', $name));

        if ($excludingId !== null) {
            $criteria = $criteria->andWhere(Criteria::expr()->neq('id', $excludingId));
        }

        if ($this->bookReadModels->exists($criteria)) {
            throw BookAlreadyExists::withName($name);
        }
    }
}
