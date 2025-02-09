<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Tests\Catalog\Book\Factory\BookFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookResource::class)]
final class UpdateBookTest extends ComponentTestCase
{
    /**
     * @return array<string, list<array<string, mixed>>>
     */
    public static function updateBookProvider(): array
    {
        return [
            'updating name' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    'name' => 'New name!',
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'New name!',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                    'tags' => [],
                    'createdAt' => '@datetime@',
                    'updatedAt' => '@datetime@',
                ],
            ],
            'updating description' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    'description' => 'New description!',
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'New description!',
                    'tags' => [],
                    'createdAt' => '@datetime@',
                    'updatedAt' => '@datetime@',
                ],
            ],
            'unsetting description' => [
                [
                    'name' => 'Advanced Web Application Architecture',
                    'description' => 'A practical guide to build web applications in a sustainable manner.',
                ],
                [
                    'description' => null,
                ],
                [
                    '@context' => '/api/contexts/Book',
                    '@id' => '/api/books/@uuid@',
                    '@type' => 'Book',
                    'id' => '@uuid@',
                    'name' => 'Advanced Web Application Architecture',
                    'tags' => [],
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
    #[DataProvider('updateBookProvider')]
    public function test_can_update_book_if_it_exists(array $source, array $input, array $output): void
    {
        $bookId = $this->createBook($source);

        $response = self::createClient()->request('PATCH', "/api/books/{$bookId}", [
            'json' => $input,
            'headers' => [
                'content-type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertMatchesPattern($output, $response->toArray());
        self::assertMatchesResourceItemJsonSchema(BookResource::class);
    }

    public function test_cannot_update_book_if_it_does_not_exist(): void
    {
        self::createClient()->request('PATCH', '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03', [
            'json' => BookFactory::createOne(),
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
            'detail' => 'Could not find book <"0194adb1-41b9-7ee2-9344-98ca0217ca03">.',
        ]);
    }

    public function test_cannot_update_book_if_book_with_name_already_exists(): void
    {
        $this->createBook([
            'name' => 'Advanced Web Application Architecture',
        ]);
        $bookId = $this->createBook();

        self::createClient()->request('PATCH', "/api/books/{$bookId}", [
            'json' => BookFactory::createOne([
                'name' => 'Advanced Web Application Architecture',
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
            'detail' => 'Book with name <"Advanced Web Application Architecture"> already exists.',
            'type' => '/errors/409',
            'status' => 409,
        ]);
    }
}
