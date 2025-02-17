<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Application\Delete;

use App\Catalog\Tag\Domain\CouldNotFindTagException;
use App\Catalog\Tag\Domain\TagId;
use App\Catalog\Tag\Domain\TagRepository;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class DeleteTagCommandHandler
{
    public function __construct(
        private TagRepository $tags,
    ) {}

    /**
     * @throws CouldNotFindTagException
     */
    #[CommandHandler]
    public function __invoke(DeleteTagCommand $command): void
    {
        $tagId = TagId::fromString($command->id);
        $tag = $this->tags->ofId($tagId) ?? throw CouldNotFindTagException::withId($tagId);
        $tag->delete();
        $this->tags->save($tag);
    }
}
