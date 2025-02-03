<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use Ecotone\Modelling\Attribute\EventSourcingAggregate;
use Ecotone\Modelling\Attribute\EventSourcingHandler;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\WithAggregateVersioning;
use Ecotone\Modelling\WithEvents;

#[EventSourcingAggregate]
final class Book
{
    use WithEvents;
    use WithAggregateVersioning;

    #[Identifier]
    public BookId $id;

    public static function create(string $id, string $name): self
    {
        $id = BookId::fromString($id);

        $self = new self();
        $self->recordThat(new BookWasCreated($id->value, $name));
        return $self;
    }

    public function update(string $name): void
    {
        $this->recordThat(new BookWasUpdated($this->id->value, $name));
    }

    public function delete(): void
    {
        $this->recordThat(new BookWasDeleted($this->id->value));
    }

    #[EventSourcingHandler]
    public function applyBookWasCreated(BookWasCreated $event): void
    {
        $this->id = BookId::fromString($event->id);
    }

    #[EventSourcingHandler]
    public function applyBookWasUpdated(BookWasUpdated $event): void {}

    #[EventSourcingHandler]
    public function applyBookWasDeleted(BookWasDeleted $event): void {}
}
