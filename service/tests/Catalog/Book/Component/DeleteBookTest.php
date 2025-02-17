<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(BookResource::class)]
final class DeleteBookTest extends ComponentTestCase
{
    public function test_can_delete_book_if_it_exists(): void
    {
        $bookId = self::createBook();

        $response = self::createClient()->request('DELETE', "/api/books/{$bookId}");

        self::assertResponseIsOk($response, BookResource::class, [
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books/@uuid@',
            '@type' => 'Book',
            'id' => $bookId,
            'name' => '@...@',
            'tags' => [],
            'deleted' => true,
            'createdAt' => '@datetime@',
            'updatedAt' => '@datetime@',
        ]);
    }

    public function test_cannot_delete_book_if_it_does_not_exist(): void
    {
        $nonExistingBookId = '0194adb1-41b9-7ee2-9344-98ca0217ca03';
        self::createClient()->request('DELETE', "/api/books/{$nonExistingBookId}");

        self::assertResponseIsNotFound("Could not find book <\"{$nonExistingBookId}\">.");
    }

    public function test_cannot_delete_book_if_its_already_deleted(): void
    {
        $bookId = self::createBook();
        self::deleteBook($bookId);

        self::createClient()->request('DELETE', "/api/books/{$bookId}");

        self::assertResponseIsNotFound("Could not find book <\"{$bookId}\">.");
    }
}
