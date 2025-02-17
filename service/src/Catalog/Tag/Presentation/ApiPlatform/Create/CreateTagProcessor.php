<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform\Create;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Tag\Application\Create\CreateTagCommand;
use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Presentation\ApiPlatform\TagFinder;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\UuidV7;

/**
 * @implements ProcessorInterface<CreateTagInput, TagResource>
 */
final readonly class CreateTagProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private TagFinder $tagFinder,
    ) {}

    /**
     * @param CreateTagInput $data
     * @throws CouldNotFindTagException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): TagResource {
        $tagId = new UuidV7();
        $this->commandBus->dispatch(new CreateTagCommand($tagId->toString(), $data->name));
        return $this->tagFinder->find($tagId, $context);
    }
}
