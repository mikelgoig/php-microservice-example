<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviourWithRequiredHistory;

/** @implements AggregateRoot<BookId> */
final class Book implements AggregateRoot
{
    /** @use AggregateRootBehaviourWithRequiredHistory<BookId> */
    use AggregateRootBehaviourWithRequiredHistory;

    public static function create(string $id, string $name): self
    {
        $id = BookId::fromString($id);
        $self = new self($id);
        $self->recordThat(new BookWasCreated($id->value, $name));
        return $self;
    }

    public function update(string $name): void
    {
        $this->recordThat(new BookWasUpdated($name));
    }

    public function applyBookWasCreated(BookWasCreated $event): void {}

    public function applyBookWasUpdated(BookWasUpdated $event): void {}
}
