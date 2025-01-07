<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Query\Get;

use App\Catalog\Domain\Model\Book\Book;
use App\Shared\Application\Bus\Query\Query;

/**
 * @implements Query<Book>
 * @see GetBookQueryHandler
 */
final readonly class GetBookQuery implements Query
{
    public function __construct(
        public string $id,
    ) {
    }
}
