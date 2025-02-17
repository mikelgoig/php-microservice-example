<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\Catalog\Tag\Factory\TagEntityFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TagResource::class)]
final class GetTagTest extends ComponentTestCase
{
    public function test_can_get_tag_if_it_exists(): void
    {
        TagEntityFactory::createOne([
            'id' => '0194dcb5-043c-7992-845d-85904d5689df',
            'name' => 'ddd',
        ]);

        $response = self::createClient()->request('GET', '/api/tags/0194dcb5-043c-7992-845d-85904d5689df');

        self::assertResponseIsOk($response, TagResource::class, [
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags/0194dcb5-043c-7992-845d-85904d5689df',
            '@type' => 'Tag',
            'id' => '0194dcb5-043c-7992-845d-85904d5689df',
            'name' => 'ddd',
            'deleted' => false,
            'createdAt' => '@datetime@',
        ]);
    }

    public function test_cannot_get_tag_if_it_does_not_exist(): void
    {
        $nonExistingTagId = '0194dcb5-cb71-722c-96e8-63d1018fbb89';
        self::createClient()->request('GET', "/api/tags/{$nonExistingTagId}");

        self::assertResponseIsNotFound();
    }
}
