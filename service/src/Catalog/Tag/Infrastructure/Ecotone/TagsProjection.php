<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Infrastructure\Ecotone;

use App\Catalog\Tag\Domain\Tag;
use App\Catalog\Tag\Domain\TagWasCreated;
use App\Catalog\Tag\Domain\TagWasDeleted;
use App\Catalog\Tag\Domain\TagWasUpdated;
use App\Shared\Domain\Dto\PatchData;
use Doctrine\DBAL\Connection as DbalConnection;
use Ecotone\EventSourcing\Attribute\Projection;
use Ecotone\Modelling\Attribute\EventHandler;

#[Projection(name: 'tags', fromStreams: Tag::class)]
final readonly class TagsProjection
{
    private const string TAGS_TABLE = 'read.tags';

    public function __construct(
        private DbalConnection $connection,
    ) {}

    #[EventHandler]
    public function onTagWasCreated(TagWasCreated $event): void
    {
        $this->connection->insert(self::TAGS_TABLE, [
            'id' => $event->id,
            'name' => $event->name,
            'created_at' => $event->occurredOn,
        ]);
    }

    #[EventHandler]
    public function onTagWasDeleted(TagWasDeleted $event): void
    {
        $this->connection->update(self::TAGS_TABLE, [
            'deleted' => true,
            'updated_at' => $event->occurredOn,
        ], [
            'id' => $event->id,
        ]);
    }

    #[EventHandler]
    public function onTagWasUpdated(TagWasUpdated $event): void
    {
        $patchData = new PatchData($event->patchData->getArrayCopy());
        $this->connection->update(self::TAGS_TABLE, [
            ...$patchData->hasKey('name') ? [
                'name' => $patchData->value('name'),
            ] : [],
            'updated_at' => $event->occurredOn,
        ], [
            'id' => $event->id,
        ]);
    }
}
