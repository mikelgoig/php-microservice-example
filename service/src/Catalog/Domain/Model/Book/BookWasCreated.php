<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

final class BookWasCreated
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
