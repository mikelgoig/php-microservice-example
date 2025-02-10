<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(TagResource::class)]
final class DeleteTagTest extends ComponentTestCase
{
    public function test_can_delete_tag_if_it_exists(): void
    {
        $tagId = $this->createTag();

        $response = self::createClient()->request('DELETE', "/api/tags/{$tagId}");

        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        self::assertEmpty($response->getContent());
    }

    public function test_cannot_delete_tag_if_it_does_not_exist(): void
    {
        self::createClient()->request('DELETE', '/api/tags/0194e22a-484a-7aad-b3a0-6efb3c7d38d9');

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
