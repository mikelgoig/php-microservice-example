<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

final class BookWasUpdated
{
    public function __construct(
        public string $name,
    ) {}
}
