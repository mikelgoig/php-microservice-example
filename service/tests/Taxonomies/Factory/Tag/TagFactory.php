<?php

declare(strict_types=1);

namespace App\Tests\Taxonomies\Factory\Tag;

use Zenstruck\Foundry\ArrayFactory;

final class TagFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->slug(),
        ];
    }
}
