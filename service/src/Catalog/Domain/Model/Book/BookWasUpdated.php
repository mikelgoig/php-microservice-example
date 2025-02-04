<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use App\Shared\Domain\DateTime\DateTimeFormatter;

final readonly class BookWasUpdated
{
    public string $occurredOn;

    public function __construct(
        public string $id,
        public string $name,
        ?string $occurredOn = null,
    ) {
        $this->occurredOn = $occurredOn ?? DateTimeFormatter::toAtomUtcString();
    }
}
