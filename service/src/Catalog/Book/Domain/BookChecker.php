<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

use Doctrine\Common\Collections\Criteria;

final readonly class BookChecker
{
    public function __construct(
        private BookReadModelRepository $bookReadModels,
    ) {}

    /**
     * @throws BookAlreadyExistsException
     */
    public function ensureThatThereIsNoBookWithName(string $name, ?BookId $excludingId = null): void
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('name', $name));

        if ($excludingId !== null) {
            $criteria = $criteria->andWhere(Criteria::expr()->neq('id', $excludingId->value));
        }

        if ($this->bookReadModels->exists($criteria)) {
            throw BookAlreadyExistsException::withName($name);
        }
    }
}
