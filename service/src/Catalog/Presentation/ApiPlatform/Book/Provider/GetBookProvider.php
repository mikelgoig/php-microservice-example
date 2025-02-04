<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Infrastructure\Doctrine\Entity\Book;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookResource;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<BookResource>
 */
final readonly class GetBookProvider implements ProviderInterface
{
    /**
     * @param ProviderInterface<Book> $itemProvider
     */
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $book = $this->itemProvider->provide($operation, $uriVariables, $context);
        \assert($book === null || $book instanceof Book);

        if ($book === null) {
            $bookId = $uriVariables['id'];
            \assert($bookId instanceof Uuid);
            throw CouldNotFindBookException::withId($bookId->toString());
        }

        // TODO: Use an Object Mapper
        $bookResource = new BookResource();
        $bookResource->id = $book->id;
        $bookResource->name = $book->name;
        $bookResource->deleted = $book->deleted;
        $bookResource->createdAt = $book->createdAt;
        $bookResource->updatedAt = $book->updatedAt;
        return $bookResource;
    }
}
