<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

use App\Shared\Domain\DateTime\DateTimeFormatter;

final readonly class TagWasUpdated
{
    public string $occurredOn;

    /**
     * @param \ArrayObject<string, mixed> $patchData
     */
    public function __construct(
        public string $id,
        public \ArrayObject $patchData,
        ?string $occurredOn = null,
    ) {
        $this->occurredOn = $occurredOn ?? DateTimeFormatter::toAtomUtcString();
    }
}
