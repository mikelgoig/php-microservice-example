<?php

declare(strict_types=1);

namespace App\Tests\Shared\ApiPlatform;

use ApiPlatform\Doctrine\Orm\State\Options as DoctrineStateOptions;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\Persistence\ManagerRegistry;
use Symfonycasts\MicroMapper\MicroMapperInterface;

/**
 * Provides functionality to find IRI by resource class and criteria
 * when API resources and entities are configured in separate classes.
 *
 * @phpstan-require-extends ApiTestCase
 */
trait ApiResourceFinder
{
    /**
     * @param array<mixed> $criteria
     */
    protected function findIriBy(string $resourceClass, array $criteria): ?string
    {
        $container = static::getContainer();

        $metadataFactory = $container->get(ResourceMetadataCollectionFactoryInterface::class);
        $this->ensureThatClassExists($resourceClass);
        $metadataCollection = $metadataFactory->create($resourceClass);
        $stateOptions = $metadataCollection[0]?->getStateOptions();
        \assert(
            $stateOptions instanceof DoctrineStateOptions,
            \sprintf('"%s" only supports classes using Doctrine state options.', __METHOD__),
        );

        $entityClass = $stateOptions->getEntityClass();
        $this->ensureThatClassExists($entityClass);

        $doctrine = $container->get(ManagerRegistry::class);
        $objectManager = $doctrine->getManagerForClass($entityClass);
        \assert($objectManager !== null, \sprintf('"%s" only supports classes managed by Doctrine ORM.', __METHOD__));

        /**
         * @var array<string, mixed> $criteria
         * @phpstan-ignore-next-line
         */
        $entity = $objectManager->getRepository($entityClass)->findOneBy($criteria);

        if ($entity === null) {
            return null;
        }

        $microMapper = $container->get(MicroMapperInterface::class);
        $resource = $microMapper->map($entity, $resourceClass);
        return $this->getIriFromResource($resource);
    }

    /**
     * @phpstan-assert class-string $class
     */
    private function ensureThatClassExists(?string $class): void
    {
        \assert($class !== null, 'Class is not defined.');
        \assert(class_exists($class), "Class <{$class}> is not a valid class-string.");
    }
}
