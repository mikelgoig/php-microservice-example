<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TagResource::class)]
final class CreateTagTest extends ComponentTestCase
{
    public function test_can_create_tag_using_valid_data(): void
    {
        $response = self::createClient()->request('POST', '/api/tags', [
            'json' => [
                'name' => 'ddd',
            ],
        ]);

        self::assertResponseIsCreated($response, TagResource::class, [
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags/@uuid@',
            '@type' => 'Tag',
            'id' => '@uuid@',
            'name' => 'ddd',
            'deleted' => false,
            'createdAt' => '@datetime@',
        ]);
    }

    public function test_cannot_create_tag_if_data_is_blank(): void
    {
        self::createClient()->request('POST', '/api/tags', [
            'json' => [],
        ]);

        self::assertResponseIsUnprocessableEntity([
            [
                'propertyPath' => 'name',
                'message' => 'This value should not be blank.',
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

        self::assertResponseIsUnprocessableEntity([
            [
                'propertyPath' => 'name',
                'message' => 'This value is too long. It should have 255 characters or less.',
            ],
        ]);
    }

    public function test_cannot_create_tag_if_tag_with_name_already_exists(): void
    {
        self::createTag([
            'name' => 'ddd',
        ]);

        self::createClient()->request('POST', '/api/tags', [
            'json' => [
                'name' => 'ddd',
            ],
        ]);

        self::assertResponseIsConflict('Tag with name <"ddd"> already exists.');
    }
}
