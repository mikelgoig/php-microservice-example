<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Component;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use App\Tests\Catalog\Factory\BookReadModelFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;

#[CoversClass(BookQueryResource::class)]
final class GetBookTest extends ComponentTestCase
{
    public function test_can_get_book_if_it_exists(): void
    {
        BookReadModelFactory::createOne([
            'id' => new UuidV7('0194adb1-41b9-7ee2-9344-98ca0217ca03'),
            'name' => 'Advanced Web Application Architecture',
        ]);

        self::createClient()->request('GET', '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03',
            '@type' => 'Book',
            'id' => '0194adb1-41b9-7ee2-9344-98ca0217ca03',
            'name' => 'Advanced Web Application Architecture',
        ]);
        self::assertMatchesResourceItemJsonSchema(BookQueryResource::class);
    }

    public function test_cannot_get_book_if_it_does_not_exist(): void
    {
        self::createClient()->request('GET', '/api/books/0194cc5d-b856-7668-8312-c93f5b66e523');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/404',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Could not find book <"0194cc5d-b856-7668-8312-c93f5b66e523">.',
        ]);
    }
}
