<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Book\Component;

use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Tests\Catalog\Book\Factory\BookEntityFactory;
use App\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(BookResource::class)]
final class GetBookTest extends ComponentTestCase
{
    public function test_can_get_book_if_it_exists(): void
    {
        BookEntityFactory::createOne([
            'id' => '0194adb1-41b9-7ee2-9344-98ca0217ca03',
            'name' => 'Advanced Web Application Architecture',
        ]);

        $response = self::createClient()->request('GET', '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03');

        self::assertResponseIsOk($response, BookResource::class, [
            '@context' => '/api/contexts/Book',
            '@id' => '/api/books/0194adb1-41b9-7ee2-9344-98ca0217ca03',
            '@type' => 'Book',
            'id' => '0194adb1-41b9-7ee2-9344-98ca0217ca03',
            'name' => 'Advanced Web Application Architecture',
            'tags' => [],
            'deleted' => false,
            'createdAt' => '@datetime@',
        ]);
    }

    public function test_cannot_get_book_if_it_does_not_exist(): void
    {
        $nonExistingBookId = '0194cc5d-b856-7668-8312-c93f5b66e523';
        self::createClient()->request('GET', "/api/books/{$nonExistingBookId}");

        self::assertResponseIsNotFound();
    }
}
