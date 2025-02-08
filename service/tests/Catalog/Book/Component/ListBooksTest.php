<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Tests\Catalog\Book\Factory\BookProjectionFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;

#[CoversClass(BookResource::class)]
final class ListBooksTest extends ComponentTestCase
{
    public function test_can_list_books_ordered_by_id_desc_by_default(): void
    {
        BookProjectionFactory::createOne([
            'id' => new UuidV7('0194e6be-19a8-7330-92e3-6205b4b8819f'),
            'name' => 'Advanced Web Application Architecture',
        ]);
        BookProjectionFactory::createOne([
            'id' => new UuidV7('0194e6be-94f4-766d-8911-ef33d159457d'),
            'name' => 'Domain-Driven Design in PHP',
        ]);

        self::createClient()->request('GET', '/api/books');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books',
            '@type' => 'Collection',
            'totalItems' => 2,
            'member' => [
                '/api/books/0194e6be-94f4-766d-8911-ef33d159457d',
                '/api/books/0194e6be-19a8-7330-92e3-6205b4b8819f',
            ],
        ]);
    }

    public function test_can_list_books_with_pagination(): void
    {
        BookProjectionFactory::createMany(100);

        $response = self::createClient()->request('GET', '/api/books');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books',
            '@type' => 'Collection',
            'totalItems' => 100,
            'member' => ['/api/books/@uuid@', '@...@'],
            'view' => [
                '@id' => '/api/books?page=1',
                '@type' => 'PartialCollectionView',
                'first' => '/api/books?page=1',
                'last' => '/api/books?page=4',
                'next' => '/api/books?page=2',
            ],
        ], $response->toArray());
        self::assertIsArray($response->toArray()['member']);
        self::assertCount(30, $response->toArray()['member']);
    }
}
