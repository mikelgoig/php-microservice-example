<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

final class Book
{
    public static function create(string $id, string $name): self
    {
        // $id = BookId::fromString($id);
        // $self = new self($id);
        // $self->recordThat(new BookWasCreated($id->value, $name));
        // return $self;
        return new self();
    }

    public function update(string $name): void
    {
        // $this->recordThat(new BookWasUpdated($name));
    }

    public function applyBookWasCreated(BookWasCreated $event): void {}

    public function applyBookWasUpdated(BookWasUpdated $event): void {}
}
