<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

final class CouldNotFindTagException extends \DomainException
{
    public static function withId(string $id): self
    {
        return new self("Could not find tag <\"{$id}\">.");
    }
}
