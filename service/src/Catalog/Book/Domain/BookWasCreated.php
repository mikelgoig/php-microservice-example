<?php

declare(strict_types=1);

namespace App\Catalog\Book\Domain;

use App\Shared\Domain\DateTime\DateTimeFormatter;

final readonly class BookWasCreated
{
    public string $occurredOn;

    /**
     * @param list<string> $tags
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public array $tags,
        ?string $occurredOn = null,
    ) {
        $this->occurredOn = $occurredOn ?? DateTimeFormatter::toAtomUtcString();
    }
}
