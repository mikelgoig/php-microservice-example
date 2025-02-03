<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Model\Book;

use App\Catalog\Application\Book\Command\Create\CreateBookCommand;
use App\Catalog\Application\Book\Command\Update\UpdateBookCommand;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\EventSourcingAggregate;
use Ecotone\Modelling\Attribute\EventSourcingHandler;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\WithAggregateVersioning;

#[EventSourcingAggregate]
final class Book
{
    use WithAggregateVersioning;

    #[Identifier]
    public BookId $id;
    public string $name;

    /**
     * @return array{0: BookWasCreated}
     */
    #[CommandHandler]
    public static function create(CreateBookCommand $command): array
    {
        $id = BookId::fromString($command->id);
        return [new BookWasCreated($id->value, $command->name)];
    }

    /**
     * @return array{0: BookWasUpdated}
     */
    #[CommandHandler]
    public function update(UpdateBookCommand $command): array
    {
        return [new BookWasUpdated($command->name)];
    }

    #[EventSourcingHandler]
    public function applyBookWasCreated(BookWasCreated $event): void
    {
        $this->id = BookId::fromString($event->id);
        $this->name = $event->name;
    }

    #[EventSourcingHandler]
    public function applyBookWasUpdated(BookWasUpdated $event): void {}
}
