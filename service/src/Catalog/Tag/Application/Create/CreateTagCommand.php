<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Application\Create;

use App\Shared\Application\Bus\Command;

/** @see CreateTagCommandHandler */
final readonly class CreateTagCommand implements Command
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
