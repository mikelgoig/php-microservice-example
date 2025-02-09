<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\TagResource;
use App\Tests\Catalog\Tag\Factory\TagFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(TagResource::class)]
final class UpdateTagTest extends ComponentTestCase
{
    public function test_can_update_tag_if_it_exists(): void
    {
        $tagId = $this->createTag();

        $response = self::createClient()->request('PATCH', "/api/tags/{$tagId}", [
            'json' => [
                'name' => 'ddd',
            ],
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Tag',
            '@id' => "/api/tags/{$tagId}",
            '@type' => 'Tag',
            'id' => $tagId,
            'name' => 'ddd',
            'createdAt' => '@datetime@',
            'updatedAt' => '@datetime@',
        ], $response->toArray());
        self::assertMatchesResourceItemJsonSchema(TagResource::class);
    }

    public function test_can_update_tag_using_merge_patch(): void
    {
        $tagId = $this->createTag([
            'name' => 'ddd',
        ]);

        $response = self::createClient()->request('PATCH', "/api/tags/{$tagId}", [
            'json' => [],
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Tag',
            '@id' => "/api/tags/{$tagId}",
            '@type' => 'Tag',
            'id' => $tagId,
            'name' => 'ddd',
            'createdAt' => '@datetime@',
        ], $response->toArray());
        self::assertMatchesResourceItemJsonSchema(TagResource::class);
    }

    public function test_cannot_update_tag_if_it_does_not_exist(): void
    {
        self::createClient()->request('PATCH', '/api/tags/0194e26a-cef5-766c-968b-ced71898bb71');

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

    public function test_cannot_update_tag_if_tag_with_name_already_exists(): void
    {
        $this->createTag([
            'name' => 'ddd',
        ]);
        $tagId = $this->createTag();

        self::createClient()->request('PATCH', "/api/tags/{$tagId}", [
            'json' => TagFactory::createOne([
                'name' => 'ddd',
            ]),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
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
                    'message' => 'Tag with name <"ddd"> already exists.',
                ],
            ],
        ]);
    }
}
