<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\Catalog\Tag\Factory\TagEntityFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TagResource::class)]
final class ListTagsTest extends ComponentTestCase
{
    public function test_can_list_tags_ordered_by_name_asc_by_default(): void
    {
        TagEntityFactory::createOne([
            'name' => 'clean-architecture',
        ]);
        TagEntityFactory::createOne([
            'name' => 'web-apis',
        ]);
        TagEntityFactory::createOne([
            'name' => 'ddd',
        ]);

        $response = self::createClient()->request('GET', '/api/tags');

        self::assertResponseIsOkCollection($response, [
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags',
            '@type' => 'Collection',
            'totalItems' => 3,
            'member' => [
                $this->findIriBy(TagResource::class, [
                    'name' => 'clean-architecture',
                ]),
                $this->findIriBy(TagResource::class, [
                    'name' => 'ddd',
                ]),
                $this->findIriBy(TagResource::class, [
                    'name' => 'web-apis',
                ]),
            ],
        ]);
    }

    public function test_can_list_tags_with_pagination(): void
    {
        TagEntityFactory::createMany(100);

        $response = self::createClient()->request('GET', '/api/tags');

        self::assertResponseIsOkCollection($response, [
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags',
            '@type' => 'Collection',
            'totalItems' => 100,
            'member' => ['/api/tags/@uuid@', '@...@'],
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
    }
}
