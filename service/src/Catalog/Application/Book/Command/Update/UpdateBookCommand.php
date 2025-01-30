<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Update;

use App\Shared\Application\Bus\Command\Command;

/**
 * @see UpdateBookCommandHandler
 */
final readonly class UpdateBookCommand implements Command
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
