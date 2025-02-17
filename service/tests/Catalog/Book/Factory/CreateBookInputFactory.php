<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Factory;

use App\Catalog\Book\Presentation\ApiPlatform\Create\CreateBookInput;
use Zenstruck\Foundry\ArrayFactory;

/** @see CreateBookInput */
final class CreateBookInputFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->unique()->text(),
        ];
    }
}
