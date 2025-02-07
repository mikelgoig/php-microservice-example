<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\TagResource;
use App\Tests\Catalog\Tag\Factory\TagProjectionFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(TagResource::class)]
final class ListTagsTest extends ComponentTestCase
{
    public function test_can_list_tags_ordered_by_name_asc_by_default(): void
    {
        TagProjectionFactory::createOne([
            'name' => 'ddd',
        ]);
        TagProjectionFactory::createOne([
            'name' => 'clean-architecture',
        ]);

        $response = self::createClient()->request('GET', '/api/tags');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags',
            '@type' => 'Collection',
            'totalItems' => 2,
            'member' => [
                [
                    '@id' => '/api/tags/@uuid@',
                    '@type' => 'Tag',
                    'id' => '@uuid@',
                    'name' => 'clean-architecture',
                    'createdAt' => '@datetime@',
                    'updatedAt' => null,
                ],
                [
                    '@id' => '/api/tags/@uuid@',
                    '@type' => 'Tag',
                    'id' => '@uuid@',
                    'name' => 'ddd',
                    'createdAt' => '@datetime@',
                    'updatedAt' => null,
                ],
            ],
        ], $response->toArray());
        self::assertMatchesResourceCollectionJsonSchema(TagResource::class);
    }

    public function test_can_list_tags_with_pagination(): void
    {
        TagProjectionFactory::createMany(100);

        $response = self::createClient()->request('GET', '/api/tags');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags',
            '@type' => 'Collection',
            'totalItems' => 100,
            'view' => [
                '@id' => '/api/tags?page=1',
                '@type' => 'PartialCollectionView',
                'first' => '/api/tags?page=1',
                'last' => '/api/tags?page=4',
                'next' => '/api/tags?page=2',
            ],
        ]);
        self::assertIsArray($response->toArray()['member']);
        self::assertCount(30, $response->toArray()['member']);
        self::assertMatchesResourceCollectionJsonSchema(TagResource::class);
    }
}
