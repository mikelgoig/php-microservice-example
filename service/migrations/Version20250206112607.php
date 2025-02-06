<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250206112607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tags table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE tags (
                id UUID NOT NULL,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(6) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
             );
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_6FBC94265E237E06 ON tags (name);
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN tags.id IS '(DC2Type:uuid)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN tags.created_at IS '(DC2Type:datetime_immutable)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN tags.updated_at IS '(DC2Type:datetime_immutable)';
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE tags;
        SQL);
    }
}
