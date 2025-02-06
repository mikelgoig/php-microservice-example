<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Infrastructure\Doctrine\Book\Book;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookResource;
use App\Shared\Infrastructure\ApiPlatform\Provider\EntityToResourceProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<BookResource>
 */
final readonly class GetBookProvider implements ProviderInterface
{
    /**
     * @param EntityToResourceProvider<Book, BookResource> $entityToResourceProvider
     */
    public function __construct(
        #[Autowire(service: EntityToResourceProvider::class)]
        private ProviderInterface $entityToResourceProvider,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $book = $this->entityToResourceProvider->provide($operation, $uriVariables, $context);

        if ($book === null) {
            $bookId = $uriVariables['id'];
            \assert($bookId instanceof Uuid);
            throw CouldNotFindBookException::withId($bookId->toString());
        }

        \assert($book instanceof BookResource);
        return $book;
    }
}
