<?php

declare(strict_types=1);

namespace App\Health;

use Doctrine\DBAL\Connection as DbalConnection;
use EQS\HealthCheckProvider\DTO\CheckDetails;
use EQS\HealthCheckProvider\DTO\HealthResponse;
use EQS\HealthCheckProvider\HealthChecker\DoctrineConnectionHealthChecker;
use EQS\HealthCheckProvider\HealthChecker\HealthCheckerInterface;
use EQS\HealthCheckProvider\RequestHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/health', methods: ['GET'])]
final readonly class HealthCheckController
{
    public function __construct(
        private DbalConnection $databaseConnection,
    ) {}

    public function __invoke(Request $request): Response
    {
        return $this->createResponse($request, [
            new DoctrineConnectionHealthChecker(new CheckDetails(
                'postgresql',
                true,
                componentType: 'datastore',
            ), $this->databaseConnection),
        ]);
    }

    /**
     * @param list<HealthCheckerInterface> $checks
     */
    private function createResponse(Request $request, array $checks): Response
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $psrRequest = $psrHttpFactory->createRequest($request);
        $requestHandler = new RequestHandler(new HealthResponse(), $checks, $psr17Factory, $psr17Factory);
        $psrResponse = $requestHandler->handle($psrRequest);
        $httpFoundationFactory = new HttpFoundationFactory();
        return $httpFoundationFactory->createResponse($psrResponse);
    }
}
