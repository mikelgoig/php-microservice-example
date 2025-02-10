<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Application\Update;

use App\Shared\Application\Bus\Command;

/** @see UpdateTagCommandHandler */
final readonly class UpdateTagCommand implements Command
{
    /**
     * @param array<string, mixed> $patchData
     */
    public function __construct(
        public string $id,
        public array $patchData,
    ) {}
}
