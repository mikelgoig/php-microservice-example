<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

use Doctrine\Common\Collections\Criteria;

interface BookReadModelRepository
{
    public function exists(Criteria $criteria): bool;
}
