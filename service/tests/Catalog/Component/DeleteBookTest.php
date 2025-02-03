<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Component;

use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookCommandResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(BookCommandResource::class)]
final class DeleteBookTest extends ComponentTestCase
{
    public function test_can_delete_book_if_it_exists(): void
    {
        $bookId = $this->createBook();

        $response = self::createClient()->request('DELETE', "/api/books/{$bookId}");

        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        self::assertEmpty($response->getContent());
    }

    public function test_cannot_delete_book_if_it_does_not_exist(): void
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

    public function test_cannot_delete_book_if_its_already_deleted(): void
    {
        $bookId = $this->createBook();
        $this->deleteBook($bookId);

        self::createClient()->request('DELETE', "/api/books/{$bookId}");

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/404',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => "Could not find book <\"{$bookId}\">.",
        ]);
    }
}
