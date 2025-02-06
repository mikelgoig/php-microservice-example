<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241216175807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create projections.books table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE SCHEMA IF NOT EXISTS projections;
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE projections.books (
                id_primary SERIAL NOT NULL,
                id UUID NOT NULL,
                name VARCHAR(255) NOT NULL,
                deleted BOOLEAN NOT NULL DEFAULT false,
                created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(6) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id_primary)
            );
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_B87C2C85BF396750 ON projections.books (id);
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_B87C2C855E237E06 ON projections.books (name);
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN projections.books.id IS '(DC2Type:uuid)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN projections.books.created_at IS '(DC2Type:datetime_immutable)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN projections.books.updated_at IS '(DC2Type:datetime_immutable)';
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE projections.books;
        SQL);
    }
}
