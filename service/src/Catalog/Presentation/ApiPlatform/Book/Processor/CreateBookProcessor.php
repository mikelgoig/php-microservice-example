<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Application\Book\Command\Create\CreateBookCommand;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookCommandResource;
use App\Catalog\Presentation\ApiPlatform\Book\Resource\BookQueryResource;
use App\Shared\Application\Bus\Command\CommandBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

/**
 * @implements<BookCommandResource, BookQueryResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): BookQueryResource {
        \assert($data instanceof BookCommandResource);
        Assert::notNull($data->name);

        $bookId = Uuid::v7();
        $this->commandBus->dispatch(new CreateBookCommand($bookId->toString(), $data->name));

        $book = $this->entityManager->find(BookQueryResource::class, $bookId->toString());
        \assert($book instanceof BookQueryResource);
        return $book;
    }
}
