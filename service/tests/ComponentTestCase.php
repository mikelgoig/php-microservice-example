<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Catalog\Factory\CreateBookFactory;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class ComponentTestCase extends ApiTestCase
{
    use ResetDatabase;
    use PHPMatcherAssertions;

    /**
     * @param array<string, mixed> $attributes
     * @return string The book ID.
     */
    protected function createBook(array $attributes = []): string
    {
        $createdBook = self::createClient()->request('POST', '/api/books', [
            'json' => CreateBookFactory::createOne($attributes),
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
}
