<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<BookQueryResource>
 */
final readonly class GetBookProvider implements ProviderInterface
{
    /**
     * @param ProviderInterface<BookQueryResource> $itemProvider
     */
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): BookQueryResource
    {
        $book = $this->itemProvider->provide($operation, $uriVariables, $context);
        \assert($book === null || $book instanceof BookQueryResource);

        if ($book === null) {
            $bookId = $uriVariables['id'];
            \assert($bookId instanceof Uuid);
            throw CouldNotFindBookException::withId($bookId->toString());
        }

        return $book;
    }
}
