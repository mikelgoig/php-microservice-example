<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

interface TagRepository
{
    public function save(Tag $tag): void;

    public function ofId(TagId $id): ?Tag;
}
