<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

final readonly class BookWasDeleted
{
    public function __construct(
        public string $id,
    ) {}
}
