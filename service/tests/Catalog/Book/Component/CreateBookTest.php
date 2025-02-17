<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(BookResource::class)]
final class CreateBookTest extends ComponentTestCase
{
    /**
     * @return array<string, list<array<string, mixed>>>
     */
    public static function createBookProvider(): array
    {
        return [
            'only required data' => [
                [
                    'name' => 'Advanced Web Application Architecture',
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
            'with optional data' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                    'tags' => [],
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                ],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $input
     * @param array<string, mixed> $output
     */
    #[DataProvider('createBookProvider')]
    public function test_can_create_book_using_valid_data(array $input, array $output): void
    {
        $response = self::createClient()->request('POST', '/api/books', [
            'json' => $input,
        ]);

        self::assertResponseIsCreated($response, BookResource::class, $output);
    }

    public function test_can_create_book_with_tags(): void
    {
        $tagId = self::createTag();

        $response = self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
                'tags' => ["/api/tags/{$tagId}"],
            ],
        ]);

        self::assertResponseIsCreated($response, BookResource::class, [
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books/@uuid@',
            '@type' => 'Book',
            'id' => '@uuid@',
            'name' => 'Advanced Web Application Architecture',
            'tags' => ["/api/tags/{$tagId}"],
            'deleted' => false,
            'createdAt' => '@datetime@',
        ]);
    }

    public function test_cannot_create_book_if_data_is_blank(): void
    {
        self::createClient()->request('POST', '/api/books', [
            'json' => [],
        ]);

        self::assertResponseIsUnprocessableEntity([
            [
                'propertyPath' => 'name',
                'message' => 'This value should not be blank.',
            ],
        ]);
    }

    public function test_cannot_create_book_if_name_is_too_long(): void
    {
        self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => 'In a world where technology and nature coexist, a young girl named Mia discovers a hidden garden filled with vibrant flowers and singing birds. Each day, she visits, learning the secrets of the plants and the stories of the creatures. This magical place becomes her sanctuary, inspiring her to protect the environment and share its beauty with others.',
            ],
        ]);

        self::assertResponseIsUnprocessableEntity([
            [
                'propertyPath' => 'name',
                'message' => 'This value is too long. It should have 255 characters or less.',
            ],
        ]);
    }

    public function test_cannot_create_book_if_book_with_name_already_exists(): void
    {
        self::createBook([
            'name' => 'Advanced Web Application Architecture',
        ]);

        self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
            ],
        ]);

        self::assertResponseIsConflict('Book with name <"Advanced Web Application Architecture"> already exists.');
    }
}
