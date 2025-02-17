<?php

declare(strict_types=1);

namespace App\Catalog\Book\Presentation\ApiPlatform\Create;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Book\Application\Create\CreateBookCommand;
use App\Catalog\Book\Domain\CouldNotFindBookException;
use App\Catalog\Book\Presentation\ApiPlatform\BookFinder;
use App\Catalog\Book\Presentation\ApiPlatform\BookResource;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\UuidV7;

/**
 * @implements ProcessorInterface<CreateBookInput, BookResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private BookFinder $bookFinder,
    ) {}

    /**
     * @param CreateBookInput $data
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
                $data->description,
                array_values(
                    array_map(fn (TagResource $tag) => $tag->id->toString(), iterator_to_array($data->tags)),
                ),
            ),
        );
        return $this->bookFinder->find($bookId, $context);
    }
}
