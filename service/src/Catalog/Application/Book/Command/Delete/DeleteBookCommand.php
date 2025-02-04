<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Delete;

use App\Shared\Application\Bus\Command;

/** @see DeleteBookCommandHandler */
final readonly class DeleteBookCommand implements Command
{
    public function __construct(
        public string $id,
    ) {}
}
