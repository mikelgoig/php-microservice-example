<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookResource::class)]
final class CreateBookTest extends ComponentTestCase
{
    public function test_can_create_book_using_valid_data(): void
    {
        $response = self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
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
            'tags' => [],
            'createdAt' => '@datetime@',
            'updatedAt' => null,
        ], $response->toArray());
        self::assertMatchesResourceItemJsonSchema(BookResource::class);
    }

    public function test_cannot_create_book_providing_null_data(): void
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
                    'message' => 'This value should not be null.',
                ],
            ],
        ]);
    }

    public function test_cannot_create_book_providing_blank_data(): void
    {
        self::createClient()->request('POST', '/api/books', [
            'json' => [
                'name' => '',
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
                    'message' => 'This value is too short. It should have 1 character or more.',
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
