<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Component\Book;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookResource;
use App\Tests\Catalog\Factory\Book\BookProjectionFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookResource::class)]
final class ListBooksTest extends ComponentTestCase
{
    public function test_can_list_books_ordered_by_id_desc_by_default(): void
    {
        BookProjectionFactory::createOne([
            'name' => 'Advanced Web Application Architecture',
        ]);
        BookProjectionFactory::createOne([
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
                    'createdAt' => '@datetime@',
                    'updatedAt' => null,
                ],
                [
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'createdAt' => '@datetime@',
                    'updatedAt' => null,
                ],
            ],
        ], $response->toArray());
        self::assertMatchesResourceCollectionJsonSchema(BookResource::class);
    }

    public function test_can_list_books_with_pagination(): void
    {
        BookProjectionFactory::createMany(100);

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
        self::assertMatchesResourceCollectionJsonSchema(BookResource::class);
    }
}
