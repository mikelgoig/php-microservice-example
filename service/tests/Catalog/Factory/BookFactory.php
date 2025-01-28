<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Factory;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BookQueryResource>
 */
final class BookFactory extends PersistentProxyObjectFactory
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
            'id' => Uuid::v7(),
            'name' => self::faker()->text(),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
