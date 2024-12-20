<?php

declare(strict_types=1);

namespace App\Catalog\Application\Book\Command\Create;

use App\Shared\Application\Bus\Command\Command;

/**
 * @see CreateBookCommandHandler
 */
final readonly class CreateBookCommand implements Command
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
