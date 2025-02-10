<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Application\Delete;

use App\Shared\Application\Bus\Command;

/** @see DeleteTagCommandHandler */
final readonly class DeleteTagCommand implements Command
{
    public function __construct(
        public string $id,
    ) {}
}
