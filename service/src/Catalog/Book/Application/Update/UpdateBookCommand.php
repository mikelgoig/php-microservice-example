<?php

declare(strict_types=1);

namespace App\Catalog\Book\Application\Update;

use App\Shared\Application\Bus\Command;

/** @see UpdateBookCommandHandler */
final readonly class UpdateBookCommand implements Command
{
    /**
     * @param array<string, mixed> $patchData
     */
    public function __construct(
        public string $id,
        public array $patchData,
    ) {}
}
