<?php

declare(strict_types=1);

namespace App\Tests\Catalog\Component;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class CreateBookTest extends ApiTestCase
{
    public function test_something(): void
    {
        $response = self::createClient()->request('GET', '/');

        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            '@id' => '/',
        ]);
    }
}
