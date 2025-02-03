<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Component;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookCommandResource;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use App\Tests\Catalog\Factory\CreateBookFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookCommandResource::class)]
final class UpdateBookTest extends ComponentTestCase
{
    public function test_can_update_book_if_it_exists(): void
    {
        $bookIri = $this->createBook();

        self::createClient()->request('PATCH', $bookIri, [
            'json' => [
                'name' => 'Advanced Web Application Architecture',
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            'name' => 'Advanced Web Application Architecture',
        ]);
        self::assertMatchesResourceItemJsonSchema(BookQueryResource::class);
    }

    public function test_cannot_update_book_if_it_does_not_exist(): void
    {
        self::createClient()->request('DELETE', '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03');

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

    /**
     * @return string The book IRI.
     */
    private function createBook(): string
    {
        $createdBook = self::createClient()->request('POST', '/api/books', [
            'json' => CreateBookFactory::createOne(),
        ]);

        $bookIri = $createdBook->toArray()['@id'];
        \assert(is_string($bookIri));
        return $bookIri;
    }
}
