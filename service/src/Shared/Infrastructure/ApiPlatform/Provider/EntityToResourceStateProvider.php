<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfonycasts\MicroMapper\MicroMapperInterface;

/**
 * @template T1 of object
 * @template T2 of object
 * @implements ProviderInterface<T2>
 */
final readonly class EntityToResourceStateProvider implements ProviderInterface
{
    /**
     * @param ItemProvider<T1> $itemProvider
     * @param CollectionProvider<T1> $collectionProvider
     */
    public function __construct(
        #[Autowire(service: ItemProvider::class)]
        private ProviderInterface $itemProvider,
        #[Autowire(service: CollectionProvider::class)]
        private ProviderInterface $collectionProvider,
        private MicroMapperInterface $microMapper,
    ) {}

    /**
     * @return ($operation is CollectionOperationInterface ? PartialPaginatorInterface<T2>|iterable<T2> : T2|null)
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $resourceClass = $operation->getClass();
        $this->ensureThatResourceClassExists($resourceClass);

        if ($operation instanceof CollectionOperationInterface) {
            $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
            $dtos = $this->microMapper->mapMultiple($entities, $resourceClass);

            if ($entities instanceof Paginator) {
                return new TraversablePaginator(
                    new \ArrayIterator($dtos),
                    $entities->getCurrentPage(),
                    $entities->getItemsPerPage(),
                    $entities->getTotalItems(),
                );
            }

            return new \ArrayIterator($dtos);
        }

        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($entity === null) {
            return null;
        }

        return $this->microMapper->map($entity, $resourceClass);
    }

    /**
     * @phpstan-assert class-string<T2> $resourceClass
     */
    private function ensureThatResourceClassExists(?string $resourceClass): void
    {
        \assert($resourceClass !== null, 'Resource class is not defined.');
        \assert(class_exists($resourceClass), 'Resource class is not a valid class-string.');
    }
}
