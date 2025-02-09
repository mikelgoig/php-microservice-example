<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use App\Catalog\Book\Infrastructure\Doctrine\BookEntity;
use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToDtoProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<BookResource>
 */
final readonly class GetBookProvider implements ProviderInterface
{
    /**
     * @param EntityToDtoProvider<BookEntity, BookResource> $entityToDtoProvider
     */
    public function __construct(
        #[Autowire(service: EntityToDtoProvider::class)]
        private ProviderInterface $entityToDtoProvider,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $book = $this->entityToDtoProvider->provide($operation, $uriVariables, $context);

        if ($book === null) {
            $bookId = $uriVariables['id'];
            \assert($bookId instanceof Uuid);
            throw CouldNotFindBookException::withId($bookId->toString());
        }

        \assert($book instanceof BookResource);
        return $book;
    }
}
