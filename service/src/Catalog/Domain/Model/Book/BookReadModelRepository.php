<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use Doctrine\Common\Collections\Criteria;

interface BookReadModelRepository
{
    public function exists(Criteria $criteria): bool;
}
