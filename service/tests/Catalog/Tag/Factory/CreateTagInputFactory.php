<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Factory;

use App\Catalog\Tag\Presentation\ApiPlatform\Create\CreateTagInput;
use Zenstruck\Foundry\ArrayFactory;

/** @see CreateTagInput */
final class CreateTagInputFactory extends ArrayFactory
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
