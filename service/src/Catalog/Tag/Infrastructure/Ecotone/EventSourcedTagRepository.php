<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Infrastructure\Ecotone;

use App\Catalog\Tag\Domain\Tag;
use App\Catalog\Tag\Domain\TagId;
use Ecotone\Modelling\Attribute\Repository;

interface EventSourcedTagRepository
{
    #[Repository]
    public function save(Tag $tag): void;

    #[Repository]
    public function findBy(TagId $tagId): ?Tag;
}
