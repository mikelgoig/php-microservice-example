<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TagResource::class)]
final class DeleteTagTest extends ComponentTestCase
{
    public function test_can_delete_tag_if_it_exists(): void
    {
        $tagId = self::createTag();

        $response = self::createClient()->request('DELETE', "/api/tags/{$tagId}");

        self::assertResponseIsOk($response, TagResource::class, [
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags/@uuid@',
            '@type' => 'Tag',
            'id' => $tagId,
            'name' => '@...@',
            'deleted' => true,
            'createdAt' => '@datetime@',
        ]);
    }

    public function test_cannot_delete_tag_if_it_does_not_exist(): void
    {
        $nonExistingTagId = '0194e22a-484a-7aad-b3a0-6efb3c7d38d9';
        self::createClient()->request('DELETE', "/api/tags/{$nonExistingTagId}");

        self::assertResponseIsNotFound("Could not find tag <\"{$nonExistingTagId}\">.");
    }

    public function test_cannot_delete_tag_if_its_already_deleted(): void
    {
        $tagId = self::createTag();
        self::deleteTag($tagId);

        self::createClient()->request('DELETE', "/api/tags/{$tagId}");

        self::assertResponseIsNotFound("Could not find tag <\"{$tagId}\">.");
    }
}
