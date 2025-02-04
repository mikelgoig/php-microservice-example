<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Factory;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BookQueryResource>
 */
final class BookProjectionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return BookQueryResource::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'id' => new UuidV7(),
            'name' => self::faker()->text(),
            'deleted' => false,
        ];
    }
}
