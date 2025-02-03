<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Factory;

use App\Catalog\Domain\Model\Book\BookWasCreated;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<BookWasCreated>
 */
final class BookWasCreatedFactory extends ObjectFactory
{
    public static function class(): string
    {
        return BookWasCreated::class;
    }

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
