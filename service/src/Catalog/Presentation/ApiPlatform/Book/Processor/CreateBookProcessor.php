<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Application\Book\Command\Create\CreateBookCommand;
use App\Catalog\Domain\Model\Book\CouldNotFindBookException;
use App\Catalog\Presentation\ApiPlatform\Book\Provider\GetBookProvider;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookCommandResource;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use App\Shared\Application\Bus\Command\CommandBus;
use Symfony\Component\Uid\UuidV7;

/**
 * @implements ProcessorInterface<BookCommandResource, BookQueryResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
        private GetBookProvider $getBookProvider,
    ) {}

    /**
     * @throws CouldNotFindBookException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): BookQueryResource {
        $bookId = new UuidV7();
        $this->commandBus->dispatch(new CreateBookCommand($bookId->toString(), $data->name));
        return $this->provide($bookId, $context);
    }

    /**
     * @param array<string, mixed> $context
     * @throws CouldNotFindBookException
     */
    private function provide(UuidV7 $bookId, array $context): BookQueryResource
    {
        $metadataCollection = $this->resourceMetadataCollectionFactory->create(BookQueryResource::class);
        $getOperation = $metadataCollection->getOperation('_api_/books/{id}{._format}_get');
        return $this->getBookProvider->provide($getOperation, [
            'id' => $bookId,
        ], $context);
    }
}
