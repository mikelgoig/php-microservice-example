<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\Catalog\Tag\Factory\UpdateTagInputFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(TagResource::class)]
final class UpdateTagTest extends ComponentTestCase
{
    /**
     * @return array<string, list<array<string, mixed>>>
     */
    public static function updateTagProvider(): array
    {
        return [
            'do not updating anything' => [
                [
                    'name' => 'ddd',
                ],
                [
                    // nothing
                ],
                [
                    '@context' => '/api/contexts/Tag',
                    '@id' => '/api/tags/@uuid@',
                    '@type' => 'Tag',
                    'id' => '@uuid@',
                    'name' => 'ddd',
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                ],
            ],
            'updating name' => [
                [
                    'name' => 'ddd',
                ],
                [
                    'name' => 'New name!',
                ],
                [
                    '@context' => '/api/contexts/Tag',
                    '@id' => '/api/tags/@uuid@',
                    '@type' => 'Tag',
                    'id' => '@uuid@',
                    'name' => 'New name!',
                    'deleted' => false,
                    'createdAt' => '@datetime@',
                    'updatedAt' => '@datetime@',
                ],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $source
     * @param array<string, mixed> $input
     * @param array<string, mixed> $output
     */
    #[DataProvider('updateTagProvider')]
    public function test_can_update_tag_if_it_exists(array $source, array $input, array $output): void
    {
        $tagId = self::createTag($source);

        $response = self::createClient()->request('PATCH', "/api/tags/{$tagId}", [
            'json' => $input,
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseIsOk($response, TagResource::class, $output);
    }

    public function test_cannot_update_tag_if_it_does_not_exist(): void
    {
        $nonExistingTagId = '0194e26a-cef5-766c-968b-ced71898bb71';
        self::createClient()->request('PATCH', "/api/tags/{$nonExistingTagId}", [
            'json' => UpdateTagInputFactory::createOne(),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseIsNotFound("Could not find tag <\"{$nonExistingTagId}\">.");
    }

    public function test_cannot_update_tag_if_tag_with_name_already_exists(): void
    {
        self::createTag([
            'name' => 'ddd',
        ]);
        $tagId = self::createTag();

        self::createClient()->request('PATCH', "/api/tags/{$tagId}", [
            'json' => UpdateTagInputFactory::createOne([
                'name' => 'ddd',
            ]),
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseIsConflict('Tag with name <"ddd"> already exists.');
    }
}
