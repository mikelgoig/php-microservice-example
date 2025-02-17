<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Factory;

use App\Catalog\Book\Presentation\ApiPlatform\Update\UpdateBookInput;
use Zenstruck\Foundry\ArrayFactory;

/** @see UpdateBookInput */
final class UpdateBookInputFactory extends ArrayFactory
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
