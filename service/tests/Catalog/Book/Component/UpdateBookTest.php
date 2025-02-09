<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Tests\Catalog\Book\Factory\BookFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookResource::class)]
final class UpdateBookTest extends ComponentTestCase
{
    public function test_can_update_book_if_it_exists(): void
    {
        $bookId = $this->createBook();

        $response = self::createClient()->request('PATCH', "/api/books/{$bookId}", [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
            ],
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books/@uuid@',
            '@type' => 'Book',
            'id' => '@uuid@',
            'name' => 'Advanced Web Application Architecture',
            'tags' => [],
            'createdAt' => '@datetime@',
            'updatedAt' => '@datetime@',
        ], $response->toArray());
        self::assertMatchesResourceItemJsonSchema(BookResource::class);
    }

    public function test_cannot_update_book_if_it_does_not_exist(): void
    {
        self::createClient()->request('PATCH', '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03', [
            'json' => BookFactory::createOne(),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/404',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Could not find book <"0194adb1-41b9-7ee2-9344-98ca0217ca03">.',
        ]);
    }

    public function test_cannot_update_book_if_book_with_name_already_exists(): void
    {
        $this->createBook([
            'name' => 'Advanced Web Application Architecture',
        ]);
        $bookId = $this->createBook();

        self::createClient()->request('PATCH', "/api/books/{$bookId}", [
            'json' => BookFactory::createOne([
                'name' => 'Advanced Web Application Architecture',
            ]),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
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
