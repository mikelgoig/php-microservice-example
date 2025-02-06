<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Factory\Book;

use Zenstruck\Foundry\ArrayFactory;

final class BookFactory extends ArrayFactory
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
