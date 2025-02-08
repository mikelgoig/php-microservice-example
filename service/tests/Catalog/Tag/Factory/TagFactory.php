<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Factory;

use Zenstruck\Foundry\ArrayFactory;

final class TagFactory extends ArrayFactory
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
