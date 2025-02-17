<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Tests\Catalog\Book\Factory\UpdateBookInputFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(BookResource::class)]
final class UpdateBookTest extends ComponentTestCase
{
    /**
     * @return array<string, list<array<string, mixed>>>
     */
    public static function updateBookProvider(): array
    {
        return [
            'do not updating anything' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                ],
                [
                    // nothing
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'tags' => [],
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                ],
            ],
            'updating name' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    'name' => 'New name!',
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'New name!',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                    'tags' => [],
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                    'updatedAt' => '@datetime@',
                ],
            ],
            'updating description' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    'description' => 'New description!',
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'New description!',
                    'tags' => [],
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                    'updatedAt' => '@datetime@',
                ],
            ],
            'unsetting description' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    'description' => null,
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'tags' => [],
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                    'updatedAt' => '@datetime@',
                ],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $source
     * @param array<string, mixed> $input
     * @param array<string, mixed> $output
     */
    #[DataProvider('updateBookProvider')]
    public function test_can_update_book_if_it_exists(array $source, array $input, array $output): void
    {
        $bookId = self::createBook($source);

        $response = self::createClient()->request('PATCH', "/api/books/{$bookId}", [
            'json' => $input,
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseIsOk($response, BookResource::class, $output);
    }

    public function test_cannot_update_book_if_it_does_not_exist(): void
    {
        $nonExistingBookId = '0194adb1-41b9-7ee2-9344-98ca0217ca03';
        self::createClient()->request('PATCH', "/api/books/{$nonExistingBookId}", [
            'json' => UpdateBookInputFactory::createOne(),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseIsNotFound("Could not find book <\"{$nonExistingBookId}\">.");
    }

    public function test_cannot_update_book_if_book_with_name_already_exists(): void
    {
        self::createBook([
            'name' => 'Advanced Web Application Architecture',
        ]);

        $bookId = self::createBook();
        self::createClient()->request('PATCH', "/api/books/{$bookId}", [
            'json' => UpdateBookInputFactory::createOne([
                'name' => 'Advanced Web Application Architecture',
            ]),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseIsConflict('Book with name <"Advanced Web Application Architecture"> already exists.');
    }
}
