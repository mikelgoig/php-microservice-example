<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Factory;

use App\Catalog\Tag\Presentation\ApiPlatform\Update\UpdateTagInput;
use Zenstruck\Foundry\ArrayFactory;

/** @see UpdateTagInput */
final class UpdateTagInputFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->unique()->slug(),
        ];
    }
}
