<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Presentation\ApiPlatform\Delete;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Tag\Application\Delete\DeleteTagCommand;
use App\Catalog\Tag\Presentation\ApiPlatform\TagFinder;
use App\Catalog\Tag\Presentation\ApiPlatform\TagResource;
use App\Shared\Application\Bus\CommandBus;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProcessorInterface<TagResource, TagResource>
 */
final readonly class DeleteTagProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private TagFinder $tagFinder,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): TagResource {
        $tagId = $uriVariables['id'];
        \assert($tagId instanceof Uuid);
        $this->commandBus->dispatch(new DeleteTagCommand($tagId->toString()));
        return $this->tagFinder->find($tagId, $context);
    }
}
