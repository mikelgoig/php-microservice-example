<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Catalog\Book\Factory\BookFactory;
use App\Tests\Catalog\Tag\Factory\TagFactory;
use App\Tests\Shared\ApiPlatform\ApiPlatformResourceFinder;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Zenstruck\Foundry\Test as Zenstruck;

abstract class ComponentTestCase extends ApiTestCase
{
    use ApiPlatformResourceFinder;
    use PHPMatcherAssertions;
    use Zenstruck\Factories;
    use Zenstruck\ResetDatabase;

    /**
     * @param array<string, mixed> $attributes
     * @return string The book ID.
     */
    protected function createBook(array $attributes = []): string
    {
        $resource = self::createClient()->request('POST', '/api/books', [
            'json' => BookFactory::createOne($attributes),
        ]);

        $id = $resource->toArray()['id'];
        \assert(is_string($id));
        return $id;
    }

    /**
     * @param string $id The book ID.
     */
    protected function deleteBook(string $id): void
    {
        self::createClient()->request('DELETE', "/api/books/{$id}");
    }

    /**
     * @param array<string, mixed> $attributes
     * @return string The tag ID.
     */
    protected function createTag(array $attributes = []): string
    {
        $resource = self::createClient()->request('POST', '/api/tags', [
            'json' => TagFactory::createOne($attributes),
        ]);

        $id = $resource->toArray()['id'];
        \assert(is_string($id));
        return $id;
    }
}
