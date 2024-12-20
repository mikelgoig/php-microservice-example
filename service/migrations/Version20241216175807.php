<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241216175807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create books table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE "books" (
                "id_primary" SERIAL,
                "id" UUID NOT NULL,
                "name" VARCHAR(255) NOT NULL,
                PRIMARY KEY("id_primary")
            );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            DROP TABLE "books";
            SQL
        );
    }
}
