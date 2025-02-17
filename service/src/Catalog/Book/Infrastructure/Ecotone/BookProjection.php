<?php

declare(strict_types=1);

namespace App\Catalog\Book\Infrastructure\Ecotone;

use App\Catalog\Book\Domain\Book;
use App\Catalog\Book\Domain\BookWasCreated;
use App\Catalog\Book\Domain\BookWasDeleted;
use App\Catalog\Book\Domain\BookWasUpdated;
use App\Shared\Domain\ValueObject\PatchData;
use Doctrine\DBAL\Connection as DbalConnection;
use Ecotone\EventSourcing\Attribute\Projection;
use Ecotone\Modelling\Attribute\EventHandler;

#[Projection(name: 'books', fromStreams: Book::class)]
final readonly class BookProjection
{
    private const string BOOKS_TABLE = 'read.books';
    private const string BOOKS_TAGS_TABLE = 'read.books_tags';

    public function __construct(
        private DbalConnection $connection,
    ) {}

    #[EventHandler]
    public function onBookWasCreated(BookWasCreated $event): void
    {
        $this->connection->insert(self::BOOKS_TABLE, [
            'id' => $event->id,
            'name' => $event->name,
            'description' => $event->description,
            'created_at' => $event->occurredOn,
        ]);

        foreach ($event->tags as $tagId) {
            $this->connection->insert(self::BOOKS_TAGS_TABLE, [
                'book_id' => $event->id,
                'tag_id' => $tagId,
            ]);
        }
    }

    #[EventHandler]
    public function onBookWasDeleted(BookWasDeleted $event): void
    {
        $this->connection->update(self::BOOKS_TABLE, [
            'deleted' => true,
            'updated_at' => $event->occurredOn,
        ], [
            'id' => $event->id,
        ]);
    }

    #[EventHandler]
    public function onBookWasUpdated(BookWasUpdated $event): void
    {
        $patchData = new PatchData($event->patchData);
        $this->connection->update(self::BOOKS_TABLE, [
            ...$patchData->hasKey('name') ? [
                'name' => $patchData->value('name'),
            ] : [],
            ...$patchData->hasKey('description') ? [
                'description' => $patchData->value('description'),
            ] : [],
            'updated_at' => $event->occurredOn,
        ], [
            'id' => $event->id,
        ]);
    }
}
