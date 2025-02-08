<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Factory;

use App\Catalog\Book\Infrastructure\Doctrine\Book;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookEntityFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Book::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'id' => new UuidV7(),
            'name' => self::faker()->unique()->text(),
            'deleted' => false,
            'createdAt' => new \DateTimeImmutable(),
        ];
    }
}
