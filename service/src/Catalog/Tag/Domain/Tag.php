<?php

declare(strict_types=1);

namespace App\Catalog\Tag\Domain;

use App\Shared\Domain\ValueObject\PatchData;
use Ecotone\Modelling\Attribute\EventSourcingAggregate;
use Ecotone\Modelling\Attribute\EventSourcingHandler;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\WithAggregateVersioning;
use Ecotone\Modelling\WithEvents;

#[EventSourcingAggregate]
final class Tag
{
    use WithEvents;
    use WithAggregateVersioning;

    #[Identifier]
    private TagId $id;
    private bool $isDeleted = false;

    public static function create(TagId $id, string $name): self
    {
        $self = new self();
        $self->recordThat(new TagWasCreated($id->value, $name));
        return $self;
    }

    public function update(PatchData $patchData): void
    {
        $this->recordThat(new TagWasUpdated($this->id->value, $patchData->data));
    }

    public function delete(): void
    {
        $this->recordThat(new TagWasDeleted($this->id->value));
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    #[EventSourcingHandler]
    public function applyTagWasCreated(TagWasCreated $event): void
    {
        $this->id = TagId::fromString($event->id);
    }

    #[EventSourcingHandler]
    public function applyTagWasUpdated(TagWasUpdated $event): void {}

    #[EventSourcingHandler]
    public function applyTagWasDeleted(TagWasDeleted $event): void
    {
        $this->isDeleted = true;
    }
}
