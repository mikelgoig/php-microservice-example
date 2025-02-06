<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Ecotone\Projection;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookWasCreated;
use App\Catalog\Domain\Model\Book\BookWasDeleted;
use App\Catalog\Domain\Model\Book\BookWasUpdated;
use Doctrine\DBAL\Connection as DbalConnection;
use Ecotone\EventSourcing\Attribute\Projection;
use Ecotone\Modelling\Attribute\EventHandler;

#[Projection(name: 'books', fromStreams: Book::class)]
final readonly class BooksProjection
{
    private const string BOOKS_TABLE = 'projections.books';

    public function __construct(
        private DbalConnection $connection,
    ) {}

    #[EventHandler]
    public function onBookWasCreated(BookWasCreated $event): void
    {
        $this->connection->insert(self::BOOKS_TABLE, [
            'id' => $event->id,
            'name' => $event->name,
            'created_at' => $event->occurredOn,
        ]);
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
        $this->connection->update(self::BOOKS_TABLE, [
            'name' => $event->name,
            'updated_at' => $event->occurredOn,
        ], [
            'id' => $event->id,
        ]);
    }
}
