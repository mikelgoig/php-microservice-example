<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

use Doctrine\Common\Collections\Criteria;

interface TagReadModelRepository
{
    public function exists(Criteria $criteria): bool;
}
