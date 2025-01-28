<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Component;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use App\Tests\Catalog\Factory\BookFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookQueryResource::class)]
final class ListBooksTest extends ComponentTestCase
{
    public function test_can_list_books(): void
    {
        BookFactory::createOne([
            'name' => 'Advanced Web Application Architecture',
        ]);
        BookFactory::createOne([
            'name' => 'Domain-Driven Design in PHP',
        ]);

        $response = self::createClient()->request('GET', '/api/books');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books',
            '@type' => 'Collection',
            'totalItems' => 2,
            'member' => [
                [
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Domain-Driven Design in PHP',
                ],
                [
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                ],
            ],
        ], $response->toArray());
        self::assertMatchesResourceCollectionJsonSchema(BookQueryResource::class);
    }

    public function test_can_list_books_with_pagination(): void
    {
        BookFactory::createMany(100);

        $response = self::createClient()->request('GET', '/api/books');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books',
            '@type' => 'Collection',
            'totalItems' => 100,
            'view' => [
                '@id' => '/api/books?page=1',
                '@type' => 'PartialCollectionView',
                'first' => '/api/books?page=1',
                'last' => '/api/books?page=4',
                'next' => '/api/books?page=2',
            ],
        ]);
        self::assertIsArray($response->toArray()['member']);
        self::assertCount(30, $response->toArray()['member']);
        self::assertMatchesResourceCollectionJsonSchema(BookQueryResource::class);
    }
}
