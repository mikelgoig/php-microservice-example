<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Tag\Component;

use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Tests\Catalog\Tag\Factory\TagFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

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
        $tagId = $this->createTag($source);

        $response = self::createClient()->request('PATCH', "/api/tags/{$tagId}", [
            'json' => $input,
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern($output, $response->toArray());
        self::assertMatchesResourceItemJsonSchema(TagResource::class);
    }

    public function test_cannot_update_tag_if_it_does_not_exist(): void
    {
        self::createClient()->request('PATCH', '/api/tags/0194e26a-cef5-766c-968b-ced71898bb71', [
            'json' => [],
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/404',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Could not find tag <"0194e26a-cef5-766c-968b-ced71898bb71">.',
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

        self::assertResponseStatusCodeSame(Response::HTTP_CONFLICT);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/409',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Tag with name <"ddd"> already exists.',
            'type' => '/errors/409',
            'status' => 409,
        ]);
    }
}
