<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Book\Application\Create\CreateBookCommand;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use App\Catalog\Book\Presentation\ApiPlatform\ApiResource\BookResource;
use App\Catalog\Tag\Tag;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\UuidV7;

/**
 * @implements ProcessorInterface<BookResource, BookResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private BookFinder $bookFinder,
    ) {}

    /**
     * @param BookResource $data
     * @throws CouldNotFindBookException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): BookResource {
        $bookId = new UuidV7();
        $this->commandBus->dispatch(
            new CreateBookCommand(
                $bookId->toString(),
                $data->name,
                $data->description ?? null,
                isset($data->tags)
                    ? array_values(array_map(fn (Tag $tag) => $tag->id->toString(), iterator_to_array($data->tags)))
                    : [],
            ),
        );
        return $this->bookFinder->find($bookId, $context);
    }
}
