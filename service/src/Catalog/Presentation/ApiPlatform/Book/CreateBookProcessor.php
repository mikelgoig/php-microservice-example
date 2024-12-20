<?php

declare(strict_types=1);

namespace App\Catalog\Presentation\ApiPlatform\Book;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Application\Book\Command\Create\CreateBookCommand;
use App\Shared\Application\Bus\Command\CommandBus;
use Webmozart\Assert\Assert;

/**
 * @implements<BookResource, BookResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        \assert($data instanceof BookResource);
        Assert::notNull($data->id);
        Assert::notNull($data->name);
        $this->commandBus->dispatch(new CreateBookCommand($data->id, $data->name));
        return BookResource::fromId($data->id);
    }
}
