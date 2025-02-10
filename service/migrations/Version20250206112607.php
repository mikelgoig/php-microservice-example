<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250206112607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create read.tags table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE SCHEMA IF NOT EXISTS read;
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE read.tags (
                id UUID NOT NULL,
                name VARCHAR(255) NOT NULL,
                deleted BOOLEAN NOT NULL DEFAULT false,
                created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(6) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
             );
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_2EFA81605E237E06 ON read.tags (name);
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN read.tags.id IS '(DC2Type:uuid)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN read.tags.created_at IS '(DC2Type:datetime_immutable)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN read.tags.updated_at IS '(DC2Type:datetime_immutable)';
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE read.tags;
        SQL);
    }
}
