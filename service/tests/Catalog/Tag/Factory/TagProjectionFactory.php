<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Factory;

use App\Catalog\Tag\TagEntity;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<TagEntity>
 */
final class TagProjectionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return TagEntity::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'id' => new UuidV7(),
            'name' => self::faker()->slug(),
        ];
    }
}
