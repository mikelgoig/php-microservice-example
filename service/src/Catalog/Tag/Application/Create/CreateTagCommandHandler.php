<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Application\Create;

use App\Catalog\Tag\Domain\Tag;
use App\Catalog\Tag\Domain\TagAlreadyExistsException;
use App\Catalog\Tag\Domain\TagChecker;
use App\Catalog\Tag\Domain\TagReadModelRepository;
use App\Catalog\Tag\Domain\TagRepository;
use Ecotone\Modelling\Attribute\CommandHandler;

final readonly class CreateTagCommandHandler
{
    private TagChecker $tagChecker;

    public function __construct(
        private TagRepository $tags,
        TagReadModelRepository $tagReadModels,
    ) {
        $this->tagChecker = new TagChecker($tagReadModels);
    }

    /**
     * @throws TagAlreadyExistsException
     */
    #[CommandHandler]
    public function __invoke(CreateTagCommand $command): void
    {
        $this->tagChecker->ensureThatThereIsNoTagWithName($command->name);
        $tag = Tag::create($command->id, $command->name);
        $this->tags->save($tag);
    }
}
