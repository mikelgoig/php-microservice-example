<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Application\Update;

use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Domain\TagAlreadyExistsException;
use App\Catalog\Tag\Domain\TagChecker;
use App\Catalog\Tag\Domain\TagId;
use App\Catalog\Tag\Domain\TagReadModelRepository;
use App\Catalog\Tag\Domain\TagRepository;
use App\Shared\Domain\ValueObject\PatchData;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class UpdateTagCommandHandler
{
    private TagChecker $tagChecker;

    public function __construct(
        private TagRepository $tags,
        TagReadModelRepository $tagReadModels,
    ) {
        $this->tagChecker = new TagChecker($tagReadModels);
    }

    /**
     * @throws CouldNotFindTagException
     * @throws TagAlreadyExistsException
     */
    #[CommandHandler]
    public function __invoke(UpdateTagCommand $command): void
    {
        $tagId = TagId::fromString($command->id);
        $patchData = new PatchData($command->patchData);

        $tag = $this->tags->ofId($tagId) ?? throw CouldNotFindTagException::withId($tagId);

        if ($patchData->isEmpty()) {
            return;
        }

        if ($patchData->hasKey('name')) {
            \assert(is_string($patchData->value('name')));
            $this->tagChecker->ensureThatThereIsNoTagWithName($patchData->value('name'), $tagId);
        }

        $tag->update($patchData);
        $this->tags->save($tag);
    }
}
