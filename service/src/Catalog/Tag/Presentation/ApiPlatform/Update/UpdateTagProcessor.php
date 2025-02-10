<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform\Update;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Tag\Application\Update\UpdateTagCommand;
use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Presentation\ApiPlatform\TagFinder;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<UpdateTagInput, TagResource>
 */
final readonly class UpdateTagProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private TagFinder $tagFinder,
    ) {}

    /**
     * @param UpdateTagInput $data
     * @throws CouldNotFindTagException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): TagResource {
        $tagId = $uriVariables['id'];
        \assert($tagId instanceof Uuid);
        $this->commandBus->dispatch(new UpdateTagCommand($tagId->toString(), (array) $data));
        return $this->tagFinder->find($tagId, $context);
    }
}
