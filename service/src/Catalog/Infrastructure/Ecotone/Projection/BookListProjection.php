<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Ecotone\Projection;

use App\Catalog\Domain\Model\Book\Book;
use App\Catalog\Domain\Model\Book\BookWasCreated;
use Doctrine\DBAL\Connection as DbalConnection;
use Ecotone\EventSourcing\Attribute\Projection;
use Ecotone\Modelling\Attribute\EventHandler;

#[Projection('book_list', Book::class)]
final readonly class BookListProjection
{
    public function __construct(
        private DbalConnection $connection,
    ) {}

    #[EventHandler]
    public function onBookWasCreated(BookWasCreated $event): void
    {
        $this->connection->insert('books', [
            'id' => $event->id,
            'name' => $event->name,
        ]);
    }
}
