<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

use App\Shared\Domain\DateTime\DateTimeFormatter;

final readonly class BookWasUpdated
{
    public string $occurredOn;

    /**
     * @param array<string, mixed> $patchData
     */
    public function __construct(
        public string $id,
        public array $patchData,
        ?string $occurredOn = null,
    ) {
        $this->occurredOn = $occurredOn ?? DateTimeFormatter::toAtomUtcString();
    }
}
