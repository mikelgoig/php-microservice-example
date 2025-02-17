<?php

declare(strict_types=1);

namespace App\Tests\Shared\ApiPlatform;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @phpstan-require-extends ApiTestCase
 */
trait ApiTestAssertions
{
    use PHPMatcherAssertions;

    /**
     * @param array<string, mixed> $pattern
     */
    public static function assertResponseIsOk(
        ResponseInterface $response,
        string $resourceClass,
        array $pattern,
    ): void {
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonMatches($response->toArray(), $pattern);
        self::assertMatchesResourceItemJsonSchema($resourceClass);
    }

    /**
     * @param array<string, mixed> $pattern
     */
    public static function assertResponseIsOkCollection(ResponseInterface $response, array $pattern): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonMatches($response->toArray(), $pattern);
    }

    /**
     * @param array<string, mixed> $pattern
     */
    public static function assertResponseIsCreated(
        ResponseInterface $response,
        string $resourceClass,
        array $pattern,
    ): void {
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonMatches($response->toArray(), $pattern);
        self::assertMatchesResourceItemJsonSchema($resourceClass);
    }

    public static function assertResponseIsUnauthorized(): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/401',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Full authentication is required to access this resource.',
        ]);
    }

    public static function assertResponseIsForbidden(): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/403',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => 'Access Denied.',
        ]);
    }

    public static function assertResponseIsNotFound(string $detail = null): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/404',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => $detail ?? 'Not Found',
        ]);
    }

    public static function assertResponseIsConflict(string $detail): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_CONFLICT);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@id' => '/api/errors/409',
            '@type' => 'Error',
            'title' => 'An error occurred',
            'detail' => $detail,
            'type' => '/errors/409',
            'status' => 409,
        ]);
    }

    /**
     * @param list<array<string, mixed>> $violations
     */
    public static function assertResponseIsUnprocessableEntity(array $violations): void
    {
        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'title' => 'An error occurred',
            'violations' => $violations,
        ]);
    }

    /**
     * @param array<mixed> $json
     * @param array<string, mixed> $pattern
     */
    public static function assertJsonMatches(array $json, array $pattern): void
    {
        TestCase::assertThat($json, self::matchesPattern($pattern));
    }
}
