<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Infrastructure\Ecotone;

use App\Catalog\Tag\Domain\Tag;
use App\Catalog\Tag\Domain\TagId;
use App\Catalog\Tag\Domain\TagRepository;

final readonly class EcotoneTagRepository implements TagRepository
{
    public function __construct(
        private EventSourcedTagRepository $eventSourcedRepository,
    ) {}

    public function save(Tag $tag): void
    {
        $this->eventSourcedRepository->save($tag);
    }

    public function ofId(TagId $id): ?Tag
    {
        $tag = $this->eventSourcedRepository->findBy($id);

        if ($tag === null) {
            return null;
        }

        if ($tag->isDeleted()) {
            return null;
        }

        return $tag;
    }
}
