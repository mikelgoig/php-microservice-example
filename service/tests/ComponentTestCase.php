<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Catalog\Book\Factory\BookFactory;
use App\Tests\Taxonomies\Factory\Tag\TagFactory;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class ComponentTestCase extends ApiTestCase
{
    use ResetDatabase;
    use Factories;
    use PHPMatcherAssertions;

    /**
     * @param array<string, mixed> $attributes
     * @return string The book ID.
     */
    protected function createBook(array $attributes = []): string
    {
        $createdBook = self::createClient()->request('POST', '/api/books', [
            'json' => BookFactory::createOne($attributes),
        ]);

        $bookId = $createdBook->toArray()['id'];
        \assert(is_string($bookId));
        return $bookId;
    }

    /**
     * @param string $bookId The book ID.
     */
    protected function deleteBook(string $bookId): void
    {
        self::createClient()->request('DELETE', "/api/books/{$bookId}");
    }

    /**
     * @param array<string, mixed> $attributes
     * @return string The tag ID.
     */
    protected function createTag(array $attributes = []): string
    {
        $createdTag = self::createClient()->request('POST', '/api/tags', [
            'json' => TagFactory::createOne($attributes),
        ]);

        $tagId = $createdTag->toArray()['id'];
        \assert(is_string($tagId));
        return $tagId;
    }
}
