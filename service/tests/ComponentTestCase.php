<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Catalog\Book\Factory\CreateBookInputFactory;
use App\Tests\Catalog\Tag\Factory\CreateTagInputFactory;
use App\Tests\Shared\ApiPlatform as ApiPlatform;
use Zenstruck\Foundry\Test as Zenstruck;

abstract class ComponentTestCase extends ApiTestCase
{
    use ApiPlatform\ApiResourceFinder;
    use ApiPlatform\ApiTestAssertions;
    use Zenstruck\Factories;
    use Zenstruck\ResetDatabase;

    /**
     * @param array<string, mixed> $attributes
     * @return string The book ID.
     */
    protected static function createBook(array $attributes = []): string
    {
        $resource = self::createClient()->request('POST', '/api/books', [
            'json' => CreateBookInputFactory::createOne($attributes),
        ]);

        $id = $resource->toArray()['id'];
        \assert(is_string($id));
        return $id;
    }

    /**
     * @param string $id The book ID.
     */
    protected static function deleteBook(string $id): void
    {
        self::createClient()->request('DELETE', "/api/books/{$id}");
    }

    /**
     * @param array<string, mixed> $attributes
     * @return string The tag ID.
     */
    protected static function createTag(array $attributes = []): string
    {
        $resource = self::createClient()->request('POST', '/api/tags', [
            'json' => CreateTagInputFactory::createOne($attributes),
        ]);

        $id = $resource->toArray()['id'];
        \assert(is_string($id));
        return $id;
    }

    /**
     * @param string $id The tag ID.
     */
    protected static function deleteTag(string $id): void
    {
        self::createClient()->request('DELETE', "/api/tags/{$id}");
    }
}
