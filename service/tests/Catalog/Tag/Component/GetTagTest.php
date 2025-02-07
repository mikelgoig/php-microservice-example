<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\TagResource;
use App\Tests\Catalog\Tag\Factory\TagProjectionFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV7;

#[CoversClass(TagResource::class)]
final class GetTagTest extends ComponentTestCase
{
    public function test_can_get_tag_if_it_exists(): void
    {
        TagProjectionFactory::createOne([
            'id' => new UuidV7('0194dcb5-043c-7992-845d-85904d5689df'),
            'name' => 'ddd',
        ]);

        self::createClient()->request('GET', '/api/tags/0194dcb5-043c-7992-845d-85904d5689df');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags/0194dcb5-043c-7992-845d-85904d5689df',
            '@type' => 'Tag',
            'id' => '0194dcb5-043c-7992-845d-85904d5689df',
            'name' => 'ddd',
        ]);
        self::assertMatchesResourceItemJsonSchema(TagResource::class);
    }

    public function test_cannot_get_tag_if_it_does_not_exist(): void
    {
        self::createClient()->request('GET', '/api/tags/0194dcb5-cb71-722c-96e8-63d1018fbb89');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/404',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Not Found',
        ]);
    }
}
