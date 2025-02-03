<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Factory;

use Zenstruck\Foundry\ArrayFactory;

final class CreateBookFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->text(),
        ];
    }
}
