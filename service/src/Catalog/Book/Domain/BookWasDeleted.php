<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

use App\Shared\Domain\DateTime\DateTimeFormatter;

final readonly class BookWasDeleted
{
    public string $occurredOn;

    public function __construct(
        public string $id,
        ?string $occurredOn = null,
    ) {
        $this->occurredOn = $occurredOn ?? DateTimeFormatter::toAtomUtcString();
    }
}
