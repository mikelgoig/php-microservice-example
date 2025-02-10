<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

use App\Shared\Domain\DateTime\DateTimeFormatter;

final readonly class TagWasCreated
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
