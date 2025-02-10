<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

final class TagAlreadyExistsException extends \DomainException
{
    public static function withName(string $name): self
    {
        return new self("Tag with name <\"{$name}\"> already exists.");
    }
}
