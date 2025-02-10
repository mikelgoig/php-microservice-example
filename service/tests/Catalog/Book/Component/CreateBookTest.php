<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

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

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern($output, $response->toArray());
        self::assertMatchesResourceItemJsonSchema(BookResource::class);
    }

    public function test_can_create_book_with_tags(): void
    {
        $tagId = $this->createTag();

        $response = self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
                'tags' => ["/api/tags/{$tagId}"],
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books/@uuid@',
            '@type' => 'Book',
            'id' => '@uuid@',
            'name' => 'Advanced Web Application Architecture',
            'tags' => ["/api/tags/{$tagId}"],
            'createdAt' => '@datetime@',
        ], $response->toArray());
        self::assertMatchesResourceItemJsonSchema(BookResource::class);
    }

    public function test_cannot_create_book_providing_blank_data(): void
    {
        self::createClient()->request('POST', '/api/books', [
            'json' => [],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'title' => 'An error occurred',
            'violations' => [
                [
                    'propertyPath' => 'name',
                    'message' => 'This value should not be blank.',
                ],
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

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'title' => 'An error occurred',
            'violations' => [
                [
                    'propertyPath' => 'name',
                    'message' => 'This value is too long. It should have 255 characters or less.',
                ],
            ],
        ]);
    }

    public function test_cannot_create_book_if_book_with_name_already_exists(): void
    {
        $this->createBook([
            'name' => 'Advanced Web Application Architecture',
        ]);

        self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_CONFLICT);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/409',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Book with name <"Advanced Web Application Architecture"> already exists.',
            'type' => '/errors/409',
            'status' => 409,
        ]);
    }
}
