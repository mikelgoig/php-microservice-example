<?php

declare(strict_types=1);

namespace App\Tests\Taxonomies\Component\Tag;

use App\Taxonomies\Tag\Tag;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(Tag::class)]
final class CreateTagTest extends ComponentTestCase
{
    public function test_can_create_tag_using_valid_data(): void
    {
        $response = self::createClient()->request('POST', '/api/tags', [
            'json' => [
                'name' => 'ddd',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern([
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags/@uuid@',
            '@type' => 'Tag',
            'id' => '@uuid@',
            'name' => 'ddd',
            'createdAt' => '@datetime@',
            'updatedAt' => null,
        ], $response->toArray());
        self::assertMatchesResourceItemJsonSchema(Tag::class);
    }

    public function test_cannot_create_tag_providing_blank_data(): void
    {
        self::createClient()->request('POST', '/api/tags', [
            'json' => [],
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
                    'message' => 'This value should not be blank.',
                ],
            ],
        ]);
    }

    public function test_cannot_create_tag_if_name_is_too_long(): void
    {
        self::createClient()->request('POST', '/api/tags', [
            'json' => [
                'name' => 'In a world where technology and nature coexist, a young girl named Mia discovers a hidden garden filled with vibrant flowers and singing birds. Each day, she visits, learning the secrets of the plants and the stories of the creatures. This magical place becomes her sanctuary, inspiring her to protect the environment and share its beauty with others.',
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
                    'message' => 'This value is too long. It should have 255 characters or less.',
                ],
            ],
        ]);
    }

    public function test_cannot_create_tag_if_tag_with_name_already_exists(): void
    {
        $this->createTag([
            'name' => 'ddd',
        ]);

        self::createClient()->request('POST', '/api/tags', [
            'json' => [
                'name' => 'ddd',
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
