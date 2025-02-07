<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Doctrine\Common\State\RemoveProcessor;
use ApiPlatform\Doctrine\Orm\State\Options as DoctrineOptions;
use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfonycasts\MicroMapper\MicroMapperInterface;

/**
 * @template TEntity of object
 * @template TDto of object
 * @implements ProcessorInterface<TDto, TDto|null>
 */
final readonly class EntityToDtoProcessor implements ProcessorInterface
{
    /**
     * @param ProcessorInterface<TEntity, TEntity> $persistProcessor
     * @param ProcessorInterface<TEntity, void> $removeProcessor
     */
    public function __construct(
        #[Autowire(service: PersistProcessor::class)]
        private ProcessorInterface $persistProcessor,
        #[Autowire(service: RemoveProcessor::class)]
        private ProcessorInterface $removeProcessor,
        private MicroMapperInterface $microMapper,
    ) {}

    /**
     * @return ($operation is DeleteOperationInterface ? null : TDto)
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ?object
    {
        $dto = $data;
        $dtoClass = $operation->getClass();
        $this->ensureThatDtoClassExists($dtoClass);
        $stateOptions = $operation->getStateOptions();
        \assert($stateOptions instanceof DoctrineOptions);
        $entityClass = $stateOptions->getEntityClass();
        $this->ensureThatEntityClassExists($entityClass);

        $entity = $this->microMapper->map($dto, $entityClass);

        if ($operation instanceof DeleteOperationInterface) {
            $this->removeProcessor->process($entity, $operation, $uriVariables, $context);
            return null;
        }

        $entity = $this->persistProcessor->process($entity, $operation, $uriVariables, $context);
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

    /**
     * @phpstan-assert class-string<TEntity> $entityClass
     */
    private function ensureThatEntityClassExists(?string $entityClass): void
    {
        \assert($entityClass !== null, 'Entity class is not defined.');
        \assert(class_exists($entityClass), "Entity class <{$entityClass}> is not a valid class-string.");
    }
}
