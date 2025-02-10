<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform\Get;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Infrastructure\Doctrine\TagEntity;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<TagResource>
 */
final readonly class GetTagProvider implements ProviderInterface
{
    /**
     * @param EntityToDtoProvider<TagEntity, TagResource> $entityToDtoProvider
     */
    public function __construct(
        #[Autowire(service: EntityToDtoProvider::class)]
        private ProviderInterface $entityToDtoProvider,
    ) {}

    /**
     * @throws CouldNotFindTagException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): TagResource
    {
        $tag = $this->entityToDtoProvider->provide($operation, $uriVariables, $context);

        if ($tag === null) {
            $tagId = $uriVariables['id'];
            \assert($tagId instanceof Uuid);
            throw CouldNotFindTagException::withId($tagId->toString());
        }

        \assert($tag instanceof TagResource);
        return $tag;
    }
}
