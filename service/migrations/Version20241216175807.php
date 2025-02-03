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
        $this->addSql(<<<SQL
            CREATE TABLE books (
                id UUID NOT NULL,
                name VARCHAR(255) NOT NULL,
                deleted BOOLEAN NOT NULL DEFAULT false,
                PRIMARY KEY(id)
            );
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_4A1B2A925E237E06 ON books (name);
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN books.id IS '(DC2Type:uuid)';
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE SCHEMA public;
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE books;
        SQL);
    }
}
