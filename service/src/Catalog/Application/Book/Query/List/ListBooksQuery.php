<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Query\List;

use App\Catalog\Domain\Model\Book\BookRepository;
use App\Shared\Application\Bus\Query\Query;

/**
 * @implements Query<BookRepository>
 * @see ListBooksQueryHandler
 */
final readonly class ListBooksQuery implements Query
{
    public function __construct(
        public ?int $offset = null,
        public ?int $limit = null,
    ) {
    }
}
