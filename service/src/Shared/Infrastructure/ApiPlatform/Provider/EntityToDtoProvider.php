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
 * @template TEntity of object
 * @template TDto of object
 * @implements ProviderInterface<TDto>
 */
final readonly class EntityToDtoProvider implements ProviderInterface
{
    /**
     * @param ItemProvider<TEntity> $itemProvider
     * @param CollectionProvider<TEntity> $collectionProvider
     */
    public function __construct(
        #[Autowire(service: ItemProvider::class)]
        private ProviderInterface $itemProvider,
        #[Autowire(service: CollectionProvider::class)]
        private ProviderInterface $collectionProvider,
        private MicroMapperInterface $microMapper,
    ) {}

    /**
     * @return ($operation is CollectionOperationInterface ? PartialPaginatorInterface<TDto>|iterable<TDto> : TDto|null)
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $dtoClass = $operation->getClass();
        $this->ensureThatDtoClassExists($dtoClass);

        if ($operation instanceof CollectionOperationInterface) {
            $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
            $dtos = $this->microMapper->mapMultiple($entities, $dtoClass);

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

        return $this->microMapper->map($entity, $dtoClass);
    }

    /**
     * @phpstan-assert class-string<TDto> $dtoClass
     */
    private function ensureThatDtoClassExists(?string $dtoClass): void
    {
        \assert($dtoClass !== null, 'DTO class is not defined.');
        \assert(class_exists($dtoClass), "DTO class <{$dtoClass}> is not a valid class-string.");
    }
}
